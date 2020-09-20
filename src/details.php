<?php include './session.php';
      require_once './users.php';
      $link = DbConnection::getConnection();

      if (isset($_GET['id']) && is_numeric($_GET['id']))
      {
          $id = $_GET['id'];
          $user = User::getById($id);
      }
?>

<html>
<?php include './head.php'; ?>
<style>
body {
    background: #f8f8f8;
}
</style>

<body style="background-color: lightgreen; background-image: linear-gradient(lightgreen, lightyellow); font-size: 20px; margin-top: 10%;">
<section>
<div class="tab-content">
<div class="container">
<div class="row flex-lg-nowrap">
<div class="col">
<div class="row">
<div class="col mb-3">
<div class="card">
<div class="card-body">
<div class="e-profile">
    <div class="row">
        <div class="col-12 col-sm-auto mb-3">
            <div class="mx-auto" style="width: 140px;">
                <div class="d-flex justify-content-center align-items-center rounded"
                    style="height: 140px; background-color: rgb(233, 236, 239);">
                    <span
                        style="color: rgb(166, 168, 170); font: bold 8pt Arial;">140x140</span>
                </div>
            </div>
        </div>
        <div
            class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
            <div class="text-center text-sm-left mb-2 mb-sm-0">
                <h2 class="pt-sm-2 pb-1 mb-0 text-nowrap">
                    <?php echo"{$user->getUserName()}"; ?></h2>
                <div class="mt-2">
                    <a href="#">
                        <button class="btn btn-block btn-primary">
                            <i class="fab fa-facebook-messenger"></i>
                            <span>Send Message</span>
                        </button>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <ul class="nav nav-tabs">
        <li class="nav-item"><a href="#" class="active nav-link">Details</a>
        </li>
    </ul>
    <div class="tab-content pt-3">
        <div class="tab-pane active">
            <form class="form" novalidate="" action="#" method="post">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="hidden" name="id"
                                value="<?php echo $id; ?>" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <label><b>Full Name: </b></label>
                            </div>
                            <div class="col">
                                <?php echo $user->getFullName(); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="phonenumber"><b>Phone number:</b></label>
                            </div>
                            <div class="col">
                                <p><?php echo $user->getPhoneNumber(); ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="email"><b>Email: </b></label>
                            </div>
                            <div class="col">
                                <p><?php echo $user->getEmail(); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                      <div class="col d-flex justify-content-end">
                      <a style="float: right;" href="./index.php">
                      Back
                    </a>
                      </div>
                    </div>
            </form>

        </div>
    </div>
</div>
</div>
</div>
</div>
</div>

</div>
</div>
</div>
</div>
</section>
</body>

</html>