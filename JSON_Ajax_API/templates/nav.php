                    <div id="hamburger-menu" class="hamburger">
                        <div class="ui menu">
                            <div class="ui simple dropdown item">
                                <i class="sidebar icon"></i>
                                Menu
                                <div class="menu">
                                <?= $this->insert('templates/nav/menu.php') ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="vodorovne-menu">
                        <div class="ui sticky massive borderless menu grid">
                            <div class="right menu">
                                <?= $this->insert('templates/nav/menu.php') ?>
                            </div>
                        </div>
                    </div>