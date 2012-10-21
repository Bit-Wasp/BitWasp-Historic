        <div class="span9 mainContent" id="your-account">
          <h2>Your Account</h2>
          <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>

          <div class="container-fluid">
            <div class="row-fluid">
              <div class="span2"><strong>Username</strong></div>
              <div class="span7"><?=$account['userName'];?></div>
            </div>

            <div class="row-fluid">
              <div class="span2"><strong>PGP Public Key</strong></div>
              <div class="span7">
                <?php if($account['pubKey'] !== 'No Public Key found.'){?>
	                <p id="pubKey"><?=$account['displayFingerprint'];?>
	                <?=anchor('account/deletePubKey','<i class="icon-trash icon-white"></i> Delete', 'class="btn btn-danger btn-mini"');?>
                  </p>
                <?php } else { ?>
	                <p id="pubKey"><?=$account['pubKey'];?></p>
                <?php } ?>
              </div>
            </div>

	    <div class="row-fluid">
	      <div class='span2'><strong>Profile URL</strong></div>
	      <div class='span7'><?=anchor("user/{$account['userHash']}",base_url()."user/{$account['userHash']}");?></div>
	    </div>

            <div class="row-fluid">
              <div class="span2"><strong>Two-Step Login</strong></div>
              <div class="span7"><p id="twoStep">
                <?php if($account['pubKey'] == 'No Public Key found.'){?>
                  Add a PGP key to enable two-step authentication.
                <?php } else {
	                // check if two-step is enabled.
	                if($account['twoStepAuth'] === '1'){?>
                    Two-step authentication enabled.
                  <?php	} else {?>
                    Edit your profile to enable this feature.
                  <?php	} 
                }?>
              </div>
            </div>

            <div class="row-fluid">
              <div class="span2"><strong>Forced PGP Messages</strong></div>
              <div class="span7"><p id="forcePGPmessage">
                <?php if($account['pubKey'] == 'No Public Key found.'){?>
                  Add a PGP key to enable two-step authentication.
                <?php } else {
	                // check if two-step is enabled.
	                if($account['forcePGPmessage'] === '1'){?>
                    Enabled.<br /><br />
                  <?php	} else {?>
                    Edit your profile to enable this feature.
                  <?php	} 
                }?>
              </div>
            </div>

            <div class="row-fluid">
              <div class="span2"><strong>Profile Message</strong></div>
              <div class="span7">
              <?php if($account['profileMessage']!=''){ ?>
                <div id="profileMessage" class="well"><?=$account['profileMessage'];?></div>
              <?php } else { ?>
                <p id="profileMessage">You have not set a profile message yet</p>
              <?php } ?>
              </div>
            </div>
          </div>
          <div class="form-actions">
            <?=anchor('account/edit', 'Edit Account', 'class="btn btn-primary"');?>
            <?=anchor('user/'.$account['userHash'], 'View Public Profile', 'class="btn"');?>
          </div>
        </div>
