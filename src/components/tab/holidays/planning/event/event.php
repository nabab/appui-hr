<div class="bbn-spadded bbn-widget">
  <div class="bbn-flex-width">
    <div class="bbn-vmiddle">
      <bbn-initial :user-name="getStaff(source.id_staff)"
                   :width="50"
                   font-size="1.5em"
      ></bbn-initial>
      <div class="bbn-hsmargin"
           :style="{width: '1em', height: '100%', backgroundColor: color}"
      ></div>
    </div>
    <div class="bbn-flex-fill bbn-hsmargin">
      <div>
        <i class="nf nf-fa-calendar"></i>
        <span v-text="startDay" class=" bbn-hsmargin"></span>
        <i v-if="!sameDay" class="nf nf-fa-long_arrow_right"></i>
        <i v-if="!sameDay" class="nf nf-fa-calendar bbn-hsmargin"></i>
        <span v-if="!sameDay" v-text="endDay"></span>
      </div>
      <div>
        <i class="nf nf-fa-user_o"></i>
        <strong><span class="bbn-hsmargin" v-text="getStaff(source.id_staff)"></span></strong>
      </div>
      <div v-if="status" :class="'bbn-' + status.color">
        <i :class="status.icon"></i>
        <strong><span class="bbn-hsmargin" v-text="status.text"></span></strong>
      </div>
      <div v-if="source.note">
        <i class="nf nf-fa-comment_o"></i>
        <span class="bbn-hsmargin"
              v-text="source.note"
              style="white-space: normal"
        ></span>
      </div>
    </div>
    <div class="bbn-xl bbn-vmiddle">
      <i v-if="showAccept"
         :class="['bbn-p', getField(hr.holidaysStatus, 'icon', {value: 'accepted'})]"
         @click="accept"
         title="<?= _('Accept') ?>"
      ></i>
      <i v-if="showCancel"
         :class="['bbn-p', 'bbn-left-sspace', getField(hr.holidaysStatus, 'icon', {value: 'cancelled'})]"
         @click="cancel"
         title="<?= _('Cancel') ?>"
      ></i>
      <i v-if="showRefuse"
         :class="['bbn-p', 'bbn-left-sspace', getField(hr.holidaysStatus, 'icon', {value: 'refused'})]"
         @click="refuse"
         title="<?= _('Refuse') ?>"
      ></i>
      <i class="nf nf-fa-address_card_o bbn-p bbn-left-sspace"
         @click="openCard"
         title="<?= _("Look at the staff card") ?>"
      ></i>
      <i class="nf nf-fa-edit bbn-p bbn-left-sspace"
         @click="edit"
         title="<?= _('Edit') ?>"
         v-if="hr.source.perms.write"
      ></i>
      <i class="nf nf-fa-trash_o bbn-p bbn-left-sspace"
         @click="remove"
         title="<?= _('Delete') ?>"
         v-if="hr.source.perms.write"
      ></i>
    </div>
  </div>
</div>