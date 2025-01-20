@echo off
setlocal enabledelayedexpansion

REM Chemin racine du projet
set "racine=%~dp0"
set "output=%racine%ListeDesFichiers.txt"

REM Nettoyage de l'ancien fichier de sortie
if exist "%output%" del "%output%"

REM Fonction pour parcourir les dossiers et fichiers
call :listFiles "%racine%" ""
echo Liste des fichiers générée dans "%output%"
pause
exit /b

:listFiles
set "folder=%~1"
set "indent=%~2"
echo - %folder% >> "%output%"
for /f "delims=" %%f in ('dir /b "%folder%"') do (
    if exist "%folder%\%%f\" (
        call :listFiles "%folder%\%%f" "  %indent%"
    ) else (
        echo %indent%  - %%f >> "%output%"
    )
)
exit /b
