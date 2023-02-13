<?php
?>
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" onclick="removeListaAutoComplete();">

    <form action="../Login/logout.php" method="post">
    
        <input type="hidden" name="logout" value="confirma">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja Realmente Sair?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-danger">
                    Caso deseje realmente sair do sistema clique no botão <i>Confirmar</i> abaixo.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
                    <button class="btn btn-primary" type="submit">Confirmar</button>
                </div>
            </div>
        </div>
    </form>

</div>