<div class='mainContent'>
<?=anchor('account/edit', 'Edit Account');?><br /><br />

<?php if(isset($returnMessage)){echo $returnMessage.'<br />';}?>
Username: <?=$account['userName'];?><br />
Link to profile: <?=anchor('user/'.$account['userHash'], base_url().'user/'.$account['userHash']);?><br /><br />
PGP Public Key: 
<?php if($account['pubKey'] !== 'No Public Key found.'){?>
<?=$account['pubKeyFingerprint'];?> - 
<?=anchor('account/deletePubKey','Delete');?><br />
<?php } else { ?>
<?=$account['pubKey'];?><br />
<?php } ?>

Two-Step Login: 
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

</form>
</div>
