<?php
/**
 * Created by PhpStorm.
 * User: leeko
 * Date: 09/01/2020
 * Time: 00:01
 */

use Util\DateUtils;

?>

<div class="container">
    <h3 class="text-dark mb-4">Profile</h3>
    <!-- define responsive width of the boxes
    <div class="row mb-3">
        <div class="col-lg-8">
            <div class="row">
                <div class="col">
                -->
    <div class="card shadow mb-3">
        <div class="card-header py-3">
            <p class="text-primary m-0 font-weight-bold">User Settings</p>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo $GLOBALS["ROOT_URL"] . "/profile/save/attributes"; ?>">
                <div class="form-group">
                    <label for="username"><strong>Username</strong></label>
                    <input class="form-control" type="text" placeholder="user.name" name="username" value="<?php echo $this->agent->name; ?>">
                </div>
                <div class="form-group">
                    <label for="email"><strong>Email Address</strong></label>
                    <input class="form-control" type="email" placeholder="user@example.com" name="email" value="<?php echo $this->agent->email; ?>">
                </div>
                <div class="form-group">
                    <label for="email"><strong>Timezone</strong></label>
                    <?php DateUtils::GetTimezonesAsDropDown($this->agent->timezone); ?>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-sm" type="submit">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow mb-3">
        <div class="card-header py-3">
            <p class="text-primary m-0 font-weight-bold">Change Password</p>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo $GLOBALS["ROOT_URL"] . "/profile/save/password"; ?>">
                <div class="form-group">
                    <label name="current_password"><strong>Current Password</strong><br></label>
                    <input class="form-control" type="password" name="current_password" for="current_password">
                </div>
                <div class="form-group"><label for="new_password"><strong>New Password</strong><br></label>
                    <input class="form-control" type="password" name="new_password" for="new_password">
                </div>
                <div class="form-group">
                    <label name="verify_password"><strong>Verify Password</strong></label>
                    <input class="form-control" type="password" name="verify_password" for="verify_password">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-sm" type="submit">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow mb-3">
        <div class="card-header py-3">
            <p class="text-primary m-0 font-weight-bold">Delete my Account</p>
        </div>
        <div class="card-body">
            <form method="post" onclick="return confirm('Are you sure to delete the account?')" action="<?php echo $GLOBALS["ROOT_URL"] . "/profile/delete"; ?>">
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">Delete</button>
                </div>
            </form>
        </div>
    </div>
    <!-- define responsive width of the boxes
    </div>
</div>
</div>
</div> -->
</div>
