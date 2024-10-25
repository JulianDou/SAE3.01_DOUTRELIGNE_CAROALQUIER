<?php
session_start();


if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
  header('Location: login.html');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Micromania - Page d'Accueil</title>
    <link rel="stylesheet" href="./dist/output.css" />
    <!-- This document uses TailwindCSS -->
  </head>
  
  <body class="py-14 h-screen bg-offwhite font-inter">

    <section id="commandes-section" class="flex flex-col gap-5 px-8">
      <div class="flex flex-col gap-10 md:gap-20 pt-16 px-5 md:px-20">
        <p class="text-micromania-blue text-2xl md:text-xl font-semibold">
          Backoffice
        </p>
        <div class="flex flex-col-reverse md:flex-row w-full gap-10 md:gap-20">
          <div class="flex flex-col gap-6 md:gap-12 w-full">
            <p class="text-micromania-blue text-2xl md:text-xl font-semibold">Commandes en cours</p>
            <div class="relative flex h-[45rem]">
              <ul id="current-orders" class="absolute top-0 left-0 h-full w-full flex flex-col gap-3 overflow-y-scroll">
                <!-- contenu chargé dynamiquement -->
              </ul>
            </div>
          </div>
          <div class="flex flex-col gap-6 md:gap-12 w-full">
            <p class="text-micromania-blue text-2xl md:text-xl font-semibold">Anciennes commandes</p>
            <div class="relative flex h-[45rem]">
              <ul id="old-orders" class="absolute top-0 left-0 h-full w-full flex flex-col gap-3 overflow-y-scroll">
                <!-- contenu chargé dynamiquement -->
              </ul>
            </div>
          </div>
        </div>
      </div>      
    </section>

    <script type="module" src="src/main.js"></script>
  </body>
</html>
