<?php
require_once(__DIR__ . '/../Bdd/bdd.php');
require_once(__DIR__ . '/../Model/UserModel.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['action'])) {
    $UserController = new UserController($bdd);

    switch ($_POST['action']) {
        case 'updateName':
            $UserController->updateName();
            break;
        case 'updateEmail':
            $UserController->updateEmail();
            break;
        case 'updatePassword':
            $UserController->updatePassword();
            break;
        case 'updateProfileImage':
            $UserController->updateProfileImage();
            break;
        case 'updateAll':
            $UserController->updateAll();
            break;
        default:
            header('Location: /ppe/index.php?error=invalid_action');
            exit();
    }
}

class UserController
{
    private $userModel;

    function __construct($bdd)
    {
        $this->userModel = new UserModel($bdd);
    }

    public function updateName()
    {
        try {
            if (!isset($_SESSION['user'])) {
                header('Location: /ppe/Vue/Auth/Login.php');
                exit();
            }

            $id = $_SESSION['user']['ID_Utilisateur'];
            $nom = $_POST['nom'] ?? null;
            $prenom = $_POST['prenom'] ?? null;

            if (!$nom || !$prenom) {
                header('Location: /ppe/Vue/User/UserProfil.php?error=missing_fields');
                exit();
            }

            $currentUser = $this->userModel->getUserById($id);
            $email = $currentUser['Email'];
            $password = $currentUser['Mdp'];
            $image = $currentUser['Images'];

            $success = $this->userModel->updateUser($id, $nom, $prenom, $email, $password, $image);
            
            if ($success) {
                $_SESSION['user'] = $this->userModel->getUserById($id);
                header('Location: /ppe/Vue/User/UserProfil.php?success=name_updated');
            } else {
                header('Location: /ppe/Vue/User/UserProfil.php?error=update_failed');
            }
            exit();
        } catch (Exception $e) {
            error_log("Name update error: " . $e->getMessage());
            header('Location: /ppe/Vue/User/UserProfil.php?error=system');
            exit();
        }
    }

    public function updateEmail()
    {
        try {
            if (!isset($_SESSION['user'])) {
                header('Location: /ppe/Vue/Auth/Login.php');
                exit();
            }

            $id = $_SESSION['user']['ID_Utilisateur'];
            $email = $_POST['email'] ?? null;

            if (!$email) {
                header('Location: /ppe/Vue/User/UserProfil.php?error=missing_fields');
                exit();
            }

            $currentUser = $this->userModel->getUserById($id);
            $nom = $currentUser['Nom'];
            $prenom = $currentUser['Prenom'];
            $password = $currentUser['Mdp'];
            $image = $currentUser['Images'];

            $success = $this->userModel->updateUser($id, $nom, $prenom, $email, $password, $image);
            
            if ($success) {
                $_SESSION['user'] = $this->userModel->getUserById($id);
                header('Location: /ppe/Vue/User/UserProfil.php?success=email_updated');
            } else {
                header('Location: /ppe/Vue/User/UserProfil.php?error=update_failed');
            }
            exit();
        } catch (Exception $e) {
            error_log("Email update error: " . $e->getMessage());
            header('Location: /ppe/Vue/User/UserProfil.php?error=system');
            exit();
        }
    }

    public function updatePassword()
    {
        try {
            if (!isset($_SESSION['user'])) {
                header('Location: /ppe/Vue/Auth/Login.php');
                exit();
            }

            $id = $_SESSION['user']['ID_Utilisateur'];
            $password = $_POST['password'] ?? null;
            $confirmPassword = $_POST['confirmPassword'] ?? null;

            if (!$password || !$confirmPassword || $password !== $confirmPassword) {
                header('Location: /ppe/Vue/User/UserProfil.php?error=password_mismatch');
                exit();
            }

            $currentUser = $this->userModel->getUserById($id);
            $nom = $currentUser['Nom'];
            $prenom = $currentUser['Prenom'];
            $email = $currentUser['Email'];
            $image = $currentUser['Images'];

            $success = $this->userModel->updateUser($id, $nom, $prenom, $email, $password, $image);
            
            if ($success) {
                $_SESSION['user'] = $this->userModel->getUserById($id);
                header('Location: /ppe/Vue/User/UserProfil.php?success=password_updated');
            } else {
                header('Location: /ppe/Vue/User/UserProfil.php?error=update_failed');
            }
            exit();
        } catch (Exception $e) {
            error_log("Password update error: " . $e->getMessage());
            header('Location: /ppe/Vue/User/UserProfil.php?error=system');
            exit();
        }
    }

    public function updateProfileImage()
    {
        try {
            if (!isset($_SESSION['user'])) {
                header('Location: /ppe/Vue/Auth/Login.php');
                exit();
            }

            $id = $_SESSION['user']['ID_Utilisateur'];
            $image = null;

            if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
                $maxFileSize = 5 * 1024 * 1024;
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

                if ($_FILES['profileImage']['size'] > $maxFileSize) {
                    header('Location: /ppe/Vue/User/UserProfil.php?error=file_too_large');
                    exit();
                }

                if (!in_array($_FILES['profileImage']['type'], $allowedTypes)) {
                    header('Location: /ppe/Vue/User/UserProfil.php?error=invalid_file_type');
                    exit();
                }

                $image = file_get_contents($_FILES['profileImage']['tmp_name']);
            }

            if (!$image) {
                header('Location: /ppe/Vue/User/UserProfil.php?error=missing_image');
                exit();
            }

            $currentUser = $this->userModel->getUserById($id);
            $nom = $currentUser['Nom'];
            $prenom = $currentUser['Prenom'];
            $email = $currentUser['Email'];
            $password = $currentUser['Mdp'];

            $success = $this->userModel->updateUser($id, $nom, $prenom, $email, $password, $image);
            
            if ($success) {
                $_SESSION['user'] = $this->userModel->getUserById($id);
                header('Location: /ppe/Vue/User/UserProfil.php?success=image_updated');
            } else {
                header('Location: /ppe/Vue/User/UserProfil.php?error=update_failed');
            }
            exit();
        } catch (Exception $e) {
            error_log("Profile image update error: " . $e->getMessage());
            header('Location: /ppe/Vue/User/UserProfil.php?error=system');
            exit();
        }
    }

    public function updateAll()
    {
        try {
            if (!isset($_SESSION['user'])) {
                header('Location: /ppe/Vue/Auth/Login.php');
                exit();
            }

            $id = $_SESSION['user']['ID_Utilisateur'];
            $nom = $_POST['nom'] ?? null;
            $prenom = $_POST['prenom'] ?? null;
            $email = $_POST['email'] ?? null;
            $password = !empty($_POST['password']) ? $_POST['password'] : null;
            $confirmPassword = $_POST['confirmPassword'] ?? null;

            if ($password && $password !== $confirmPassword) {
                header('Location: /ppe/Vue/User/UserProfil.php?error=password_mismatch');
                exit();
            }

            $image = null;
            if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
                $maxFileSize = 5 * 1024 * 1024;
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

                if ($_FILES['profileImage']['size'] > $maxFileSize) {
                    header('Location: /ppe/Vue/User/UserProfil.php?error=file_too_large');
                    exit();
                }

                if (!in_array($_FILES['profileImage']['type'], $allowedTypes)) {
                    header('Location: /ppe/Vue/User/UserProfil.php?error=invalid_file_type');
                    exit();
                }

                $image = file_get_contents($_FILES['profileImage']['tmp_name']);
            }

            if (!$nom || !$prenom || !$email) {
                header('Location: /ppe/Vue/User/UserProfil.php?error=missing_fields');
                exit();
            }

            $success = $this->userModel->updateUser($id, $nom, $prenom, $email, $password, $image);
            
            if ($success) {
                $_SESSION['user'] = $this->userModel->getUserById($id);
                header('Location: /ppe/Vue/User/UserProfil.php?success=profile_updated');
            } else {
                header('Location: /ppe/Vue/User/UserProfil.php?error=update_failed');
            }
            exit();
        } catch (Exception $e) {
            error_log("Profile update error: " . $e->getMessage());
            header('Location: /ppe/Vue/User/UserProfil.php?error=system');
            exit();
        }
    }

    public function listUsers()
    {
        return $this->userModel->getAllUsers();
    }

    public function getProfile($id)
    {
        return $this->userModel->getUtilisateurById($id);
    }

    public function updateProfile()
    {
        try {
            if (!isset($_SESSION['user'])) {
                header('Location: /ppe/Vue/Auth/Login.php');
                exit();
            }

            $id = $_SESSION['user']['ID_Utilisateur'];
            $nom = $_POST['nom'] ?? null;
            $prenom = $_POST['prenom'] ?? null;
            $email = $_POST['email'] ?? null;
            $password = !empty($_POST['password']) ? $_POST['password'] : null;

            $image = null;
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
                $maxFileSize = 5 * 1024 * 1024;
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

                if ($_FILES['profile_image']['size'] > $maxFileSize) {
                    header('Location: /ppe/Vue/User/UserProfil.php?error=file_too_large');
                    exit();
                }

                if (!in_array($_FILES['profile_image']['type'], $allowedTypes)) {
                    header('Location: /ppe/Vue/User/UserProfil.php?error=invalid_file_type');
                    exit();
                }

                $image = file_get_contents($_FILES['profile_image']['tmp_name']);
            }

            if (!$nom || !$prenom || !$email) {
                header('Location: /ppe/Vue/User/UserProfil.php?error=missing_fields');
                exit();
            }

            $success = $this->userModel->updateUser($id, $nom, $prenom, $email, $password, $image);
            
            if ($success) {
                $_SESSION['user'] = $this->userModel->getUserById($id);
                header('Location: /ppe/Vue/User/UserProfil.php?success=profile_updated');
            } else {
                header('Location: /ppe/Vue/User/UserProfil.php?error=update_failed');
            }
            exit();
        } catch (Exception $e) {
            error_log("Profile update error: " . $e->getMessage());
            header('Location: /ppe/Vue/User/UserProfil.php?error=system');
            exit();
        }
    }

    public function adminUpdateUser()
    {
        try {
            if (!isset($_SESSION['user']) || $_SESSION['user']['User_role'] !== 'Admin') {
                header('Location: /ppe/Vue/Auth/Login.php');
                exit();
            }

            $id = $_POST['id'] ?? null;
            $nom = $_POST['nom'] ?? null;
            $prenom = $_POST['prenom'] ?? null;
            $email = $_POST['email'] ?? null;
            $user_role = $_POST['user_role'] ?? null;
            $password = !empty($_POST['password']) ? $_POST['password'] : null;

            if (!$id || !$nom || !$prenom || !$email || !$user_role) {
                header('Location: /ppe/Vue/Admin/AdminEditUser.php?id=' . $id . '&error=missing_fields');
                exit();
            }

            $success = $this->userModel->adminUpdateUser($id, $nom, $prenom, $email, $user_role, $password);
            
            if ($success) {
                header('Location: /ppe/Vue/Admin/AdminListUsers.php?success=user_updated');
            } else {
                header('Location: /ppe/Vue/Admin/AdminEditUser.php?id=' . $id . '&error=update_failed');
            }
            exit();
        } catch (Exception $e) {
            error_log("Admin user update error: " . $e->getMessage());
            header('Location: /ppe/Vue/Admin/AdminListUsers.php?error=system');
            exit();
        }
    }
}
