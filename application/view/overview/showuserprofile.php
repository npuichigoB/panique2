<div class="container">
    <h1>OverviewController/showuserprofile/:id</h1>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>What happens here ?</h3>
        <p>
            This controller/action/view shows all public information about a certain user.
        </p>
        <p>
            <table class="overview-table">
                <thead>
                <tr>
                    <td>Id</td>
                    <td>Avatar</td>
                    <td>Username</td>
                    <td>User's email</td>
                    <td>Activated ?</td>
                    <td>Link to user's profile</td>
                </tr>
                </thead>
                <?php if ($this->user) { ?>
                    <tr class="<?= ($this->user->user_active == 0 ? 'inactive' : 'active'); ?>">
                        <td><?= $this->user->user_id; ?></td>
                        <td class="avatar">
                            <?php if (isset($this->user->user_avatar_link)) { ?>
                                <img src="<?= $this->user->user_avatar_link; ?>" />
                            <?php } ?>
                        </td>
                        <td><?= $this->user->user_name; ?></td>
                        <td><?= $this->user->user_email; ?></td>
                        <td><?= ($this->user->user_active == 0 ? 'No' : 'Yes'); ?></td>
                        <td>
                            <a href="<?= URL . 'overview/showuserprofile/' . $this->user->user_id; ?>">Profile</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </p>
    </div>
</div>
