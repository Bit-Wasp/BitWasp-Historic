<div class='mainContent'>
<?=anchor('account/edit', 'Edit Account');?><br /><br />
<?php if(isset($returnMessage)){echo $returnMessage.'<br />';}?>


<fieldset>
<label for='username'>Username</label> <?=$account['userName'];?><br /><br />

<label for='link'>Link to profile</label> <?=anchor('user/'.$account['userHash'], base_url().'user/'.$account['userHash']);?><br /><br />

<label for='pubKey'>PGP Public Key</label>
<?php if($account['pubKey'] !== 'No Public Key found.'){?>
	<?=$account['displayFingerprint'];?> - 
	<?=anchor('account/deletePubKey','Delete');?><br />
<?php } else { ?>
	<?=$account['pubKey'];?><br />
<?php } ?>
<br />

<label for='twoStep'>Two-Step Login</label>
<?php if($account['pubKey'] == 'No Public Key found.'){?>
Add a PGP key to enable two-step authentication.<br />
<?php } else {
	// check if two-step is enabled.
	if($account['twoStepAuth'] === '1'){?>
Two-step authentication enabled.<br />
<?php	} else {?>
Edit your profile to enable this feature.<Br />
<?php	} 
}?>
<br />
<label for='profileMessage'>Profile Message</label>
<?=$account['profileMessage'];?>
<br />

</fieldset>
</div>
