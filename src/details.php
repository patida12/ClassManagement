<?php include './session.php';
      require_once './users.php';
      $link = DbConnection::getConnection();

      if (isset($_GET['id']) && is_numeric($_GET['id']))
      {
          $id = $_GET['id'];
          $user = User::getById($id);        
      }
?>

<?php include './index.php'; ?>
<body class="link-tab">
<section>
<div class="tab-content" style="margin-right: 15%; margin-top: 5%;">
<div class="card">
<div class="card-body">
<div class="e-profile">
    <div class="row">
        <div
            class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
            <div class="text-center text-sm-left mb-2 mb-sm-0">
                <h2 class="pt-sm-2 pb-1 mb-0 text-nowrap">
                    <?php echo"{$user->getUserName()}"; ?></h2>
                <div class="mt-2">
                    <a href="#demo" class="btn btn-block btn-success" data-toggle="modal" data-target="#myModal">
                        <i class="fab fa-facebook-messenger"></i>
                        <span>Send Message</span>
                    </a>
                    <div class="modal" id="myModal">
                        <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                            <h4 class="modal-title">Enter message here...</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                            <form action="sendMess.php" id="form_upload" method="POST">   
                                <input type="hidden" name="idSender" style="margin-top: 1%; margin-bottom: 1%;" value="<?php echo $_SESSION['id']; ?>" />
                                <input type="hidden" name="idReceiver" style="margin-top: 1%; margin-bottom: 1%;" value="<?php echo $id; ?>" />
                                <textarea rows="5" id="message" name="message" style="width: 100%;"></textarea><br>
                                <input type="submit" name="submit" value="Send" class="btn btn-primary"><br>
                            </form>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                </div><br>
                <div class="row">
                    <div class="col">
                        <label for="phonenumber"><b>Phone number:</b></label>
                    </div>
                    <div class="col">
                        <p><?php echo $user->getPhoneNumber(); ?></p>
                    </div>
                </div><br>
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
                <a href='javascript:history.back(1);' style="float: right;"><button type="button" class="btn btn-primary">Back</button></a>
            </div>
        </div>
    </form>


</div>
</div>
</div>
</div>
</section>
</body>
