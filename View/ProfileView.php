<?php
/**
 * Created by PhpStorm.
 * User: leeko
 * Date: 09/01/2020
 * Time: 00:01
 */

?>

<div class="container-fluid">
    <h3 class="text-dark mb-4">Profile</h3>
    <div class="row mb-3">
        <div class="col-lg-8">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-bold">User Settings</p>
                        </div>
                        <div class="card-body">
                            <form method="post" action="">
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label
                                                    for="username"><strong>Username</strong></label><input
                                                    class="form-control" type="text" placeholder="user.name"
                                                    name="username" value="<?php echo $this->agent->name; ?>"></div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="email"><strong>Email
                                                    Address</strong></label><input class="form-control" type="email"
                                                                                   placeholder="user@example.com"
                                                                                   name="email" value="<?php echo $this->agent->email; ?>"></div>
                                    </div>
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
                            <form>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label name="current_password"><strong>Current
                                                    Password</strong><br></label><input class="form-control" type="text"
                                                                                        name="current_password"
                                                                                        for="current_password"></div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="new_password"><strong>New
                                                    Password</strong><br></label><input class="form-control" type="text"
                                                                                        for="new_password"></div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label name="verify_password"><strong>Verify
                                                    Password</strong></label><input class="form-control" type="text"
                                                                                    name="verify_password"></div>
                                    </div>
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
                            <form>
                                <div class="form-group">
                                    <button class="btn btn-danger" type="button">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
