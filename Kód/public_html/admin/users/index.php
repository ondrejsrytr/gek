<?php
include "../head.php";
?>
    <script>
        function deleteAccount(event) {
            event.preventDefault();
            $('#deleteaccount').modal('show');

            var autofill_elems = document.getElementById("deleteaccount").querySelectorAll("*[data-autofill]");
            for(var i = 0; i < autofill_elems.length; i++) {
                autofill_elems[i].innerHTML = event.currentTarget.getAttribute("data-" + autofill_elems[i].getAttribute("data-autofill"));
            }
            var autofill_val_elems = document.getElementById("deleteaccount").querySelectorAll("*[data-autofill-value]");
            for(var i = 0; i < autofill_val_elems.length; i++) {
                autofill_val_elems[i].value = event.currentTarget.getAttribute("data-" + autofill_val_elems[i].getAttribute("data-autofill-value"));
            }
        }
    </script>
    <div class="container-fluid admin">
        <div class="row row-eq-height">
            <div class="col-lg-2">
                <?php include "../menu.php"; ?>
            </div>
            <div class="col-lg-10">
                <div class="col-content">
                    <!-- OBSAH STRÁNKY -->
                    <h4>Uživatelé</h4>
                    <script>
                        $(document).ready(function () {
                            $('#table_of_users').DataTable( {
                                "order": [[ 0, "asc" ]]
                            });
                        });
                    </script>
                    <table id="table_of_users" class="table table-striped table-bordered">
                        <thead>
                        <th>ID</th>
                        <th>Jméno</th>
                        <th>Email</th>
                        <th></th>
                        </thead>
                        <tbody>
                        <?php
                        include_once ROOT."classes/db.php";
                        $dotaz = "SELECT * FROM Users";
                        $vysledek = $pdo->prepare($dotaz);
                        $vysledek->execute();
                        $result = $vysledek->fetchAll(\PDO::FETCH_ASSOC);
                        $pocet = $vysledek->rowCount();
                        for ($i = 0; $i < $pocet; $i++) {
                            echo '<tr>';
                            echo '<td>';
                            print $result[$i]["id"];
                            echo '</td>';
                            echo '<td>';
                            print '<a target="blank" href="/user?&id='.$result[$i]["id"].'">'.$result[$i]["jmeno"].'</a>';
                            echo '</td>';
                            echo '<td>';
                            print $result[$i]["email"];
                            echo '</td>';
                            echo '<td>';
                            if($result[$i]["id"] != $_SESSION['user']->getId()) echo '<div class="dropdown"><button class="btn btn-link btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Akce</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton"><a data-account-id="'.$result[$i]["id"].'" class="dropdown-item" href="#" onclick="showEditDialog(this.getAttribute(\'data-account-id\'));">Změnit údaje</a><a class="dropdown-item text-danger" data-account-id="'.$result[$i]["id"].'" data-account-name="'.$result[$i]["jmeno"].'" onclick="deleteAccount(event)" href="#">Smazat</a></div></div>';
                            //if($result[$i]["id"] != $_SESSION['user']->getId()) echo '<div class="dropdown"><button class="btn btn-link btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Akce</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton"><a class="dropdown-item text-danger" data-account-id="'.$result[$i]["id"].'" data-account-name="'.$result[$i]["jmeno"].'" onclick="deleteAccount(event)" href="#">Smazat</a></div></div>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="deleteaccount" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Smazat účet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Opravdu chcete smazat účet <span data-autofill="account-name"></span> (ID:<span data-autofill="account-id"></span>)?</p>
                </div>
                <div class="modal-footer">
                    <form action="deleteaccount.php" method="post">
                        <input name="id" type="hidden" data-autofill-value="account-id">
                        <button type="submit" class="btn btn-danger">Ano</button>
                    </form>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Ne</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="editUser" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="updateUser.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUser">Správa uživatele</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" name="id" value="">
                        <div class="form-group">
                            <label for="jmeno">Jméno</label>
                            <input id="jmeno" name="jmeno" class="form-control" type="text">
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input id="email" name="email" class="form-control" type="email">
                        </div>

                        <div class="form-group">
                            <label for="password">Heslo</label>
                            <input id="password" name="heslo" class="form-control" type="password">
                            <input id="viewpass" type="checkbox">
                            <label for="viewpass">Zobrazit heslo</label>
                        </div>

                        <div class="form-group">
                            <label for="opravneni">Oprávnění</label>
                            <select id="opravneni" name="opravneni" class="form-control">
                                <?php
                                foreach (User::getPoleOpravneni() as $index => $opravneni) {
                                    echo '<option value="'.$index.'">'.$opravneni['name'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Zrušit</button>
                        <button type="submit" class="btn btn-primary">Uložit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
include "../foot.php";
?>