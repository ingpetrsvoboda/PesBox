<!DOCTYPE html>

<html lang="cs">
    <?= $this->insert("templates/head.php") ?>
    <body>
        <div class="ui centered grid">
            <div class="sixteen wide mobile fourteen wide tablet thirteen wide computer column">
                <header>
                    <?= $this->insert("templates/header.php") ?>
                </header>
                <nav>
                    <?= $this->insert("templates/nav.php") ?>
                </nav>
                <main <?= $this->attributes($mainAttributes) ?> >
                    <?= $this->insert("templates/main.php", $main) ?>
                </main>
                <footer>
                    <?= $this->insert("templates/footer.php") ?>
                </footer>
            </div>
        </div>
        <?= $this->insert("templates/bodyLinks.php") ?>

        <script>
            semanticGlue();
        </script>

    </body>
</html>