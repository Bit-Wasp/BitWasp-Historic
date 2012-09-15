        <div class="span9 mainContent" id="send-message">
          <h2>Create Message</h2>
          <?php echo form_open('messages/send', array('name'=>'sendMessageForm', 'class' => 'form-horizontal')); ?>
            <fieldset>
              <?php if($returnMessage!='') echo '<div class="alert">' . $returnMessage . '</div>'; ?>

              <div class="control-group">
                <label class="control-label" for="recipient">Recipient</label>
                <div class="controls">
                  <input type='text' name='recipient' value="<?=$to?>" />
                  <span class="help-inline"><?php echo form_error('recipient'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="subject">Message Subject</label>
                <div class="controls">
                  <input type='text' name='subject' value="<? if(isset($subject)){ echo $subject; } ?>" />
                  <span class="help-inline"><?php echo form_error('subject'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="message">Message</label>
                <div class="controls">
                  <textarea name="message"><?=set_value('message'); ?></textarea>
                  <span class="help-inline"><?php echo form_error('message'); ?></span>
                </div>
              </div>

              <textarea style="display:none;" name="pubkey"><?=$publickey; ?></textarea><br />

              <div class="form-actions">
                <input type='submit' class="btn btn-primary" value="Send" onclick='messageEncrypt()' />
                <?=anchor('messages', 'Cancel', 'class="btn"');?>
              </div>
            </fieldset>
          </form>
</div>
