<?php
require_once("./bootstrap.php");
?>
<script src="./classi/script.js"></script>
<div class="container-xl">


  <div class="row mx-0">
    <div class="col p-3 my-4 mx-3">
      <div class="mb-2 h1"><?php echo $templateParams['gridTitle']; ?></div>
      <div class="h3"><?php echo $_SESSION["clientEmail"] ?></div>
    </div>
  </div>
  <div class="row mx-0 text-center">
    <div class="col p-3 my-4 mx-3">
      <button data-bs-toggle="modal" data-bs-target="#mailBackdrop" class="btn btn-success btn-lg">Modifica Mail</button>
    </div>
    <div class="col p-3 my-4 mx-3">
      <button data-bs-toggle="modal" data-bs-target="#passwordBackdrop" class="btn btn-success btn-lg">Modifica Password</button>
    </div>
  </div>

  <!-- Modal Mail -->
  <div class="modal fade" id="mailBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="mailBackdrop" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modifica Mail</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="POST">
          <div class="modal-body">
            <div class="row">
              <div class="col-8 my-2">
                <label class="ps-1 fs-5" for="newMail">Inserire Nuova Mail </label>
                <input type="text" class="form-control" required placeholder="Nuova Mail" name="newMail" id="newMail">
              </div>
              <div class="col-8 my-2">
                <label class="ps-1 fs-5" for="checkNewMail">Conferma Nuova Mail </label>
                <input type="text" class="form-control" required placeholder="Ripeti Nuova Mail" name="checkNewMail" id="checkNewMail">
              </div>
              <span id='mailMessage'></span>
            </div>
            <div class="modal-footer mt-3">
              <input type="submit" id="confirmMail" class="btn btn-success" value="Conferma">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Password -->
  <div class="modal fade" id="passwordBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="passwordBackdrop" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modifica Password</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="POST">
          <div class="modal-body">
            <div class="row">
              <div class="col-8 my-2">
                <label class="ps-1 fs-5" for="oldPassword">Inserire Password Attuale</label>
                <div class="input-group my-2">
                  <input type="password" class="form-control" required placeholder="Password" name="oldPassword" id="oldPassword">
                  <div class="input-group-append">
                    <button class="btn btn-lg btn-outline-secondary fa fa-eye" type="button" onclick="showPwd(document.getElementById('oldPassword'), this)" id="iconPwd"></button>
                  </div>
                </div>
              </div>
              <div class="col-8 my-2">
                <label class="ps-1 fs-5" for="newPassword">Inserire Nuova Password </label>
                <div class="input-group my-2">
                  <input type="password" class="form-control" required placeholder="Nuova Password" name="newPassword" id="newPassword">
                  <div class="input-group-append">
                    <button class="btn btn-lg btn-outline-secondary fa fa-eye" type="button" onclick="showPwd(document.getElementById('newPassword'), this)" id="iconPwd"></button>
                  </div>
                </div>
              </div>
              <div class="col-8 my-2">
                <label class="ps-1 fs-5" for="checkNewPassword">Conferma Nuova Password </label>
                <div class="input-group my-2">
                  <input type="password" class="form-control" required placeholder="Ripeti Nuova Password" name="checkNewPassword" id="checkNewPassword">
                  <div class="input-group-append">
                    <button class="btn btn-lg btn-outline-secondary fa fa-eye" type="button" onclick="showPwd(document.getElementById('checkNewPassword'), this)" id="iconPwd"></button>
                  </div>
                </div>
              </div>
              <span id='passwordMessage'></span>
            </div>
            <div class="modal-footer mt-3">
              <input type="submit" id="confirmPassword" class="btn btn-success" value="Conferma">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
if (isset($templateParams["erroreLogin"])) : ?>
  <script>
    alert("<?php echo $templateParams["erroreLogin"]; ?>");
  </script>
<?php endif; ?>