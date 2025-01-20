<!-- VueContact.php -->
<?php include('Navbar.php'); ?>
<div class="container my-5">
    <h1>Contactez-nous</h1>
    <p>Veuillez remplir le formulaire ci-dessous. Nous reviendrons vers vous rapidement.</p>

    <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
        <div class="alert alert-success">Votre message a été envoyé avec succès !</div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger">Une erreur est survenue. Veuillez réessayer.</div>
    <?php endif; ?>

    <form action="index.php?page=contactAction" method="POST">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" id="message" rows="5" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>

<?php renderFooter(); ?>
