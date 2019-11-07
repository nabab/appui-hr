<div>
  <div class="bbn-c">
    <i class="nf nf-fa-user_circle_o" style="font-size: 10em"></i>
  </div>
  <div v-if="group" 
       class="bbn-c bbn-top-space bbn-large bbn-tertiary-text-alt"
  >
    <span v-text="group"></span>
  </div>
  <div class="bbn-grid-fields bbn-top-space">
    <label><?=_('Surname')?></label>
    <div v-text="source.surname"></div>
    <label><?=_('Name')?></label>
    <div v-text="source.name"></div>
    <label><?=_('eMail')?></label>
    <div v-text="source.email"></div>
    <label><?=_('Phone')?></label>
    <div v-text="source.tel"></div>
    <label><?=_('Address')?></label>
    <div v-text="source.adresse"></div>
    <label><?=_('Postal Code')?></label>
    <div v-text="source.cp"></div>
    <label><?=_('City')?></label>
    <div v-text="source.ville"></div>
    <label><?=_('Contact')?></label>
    <div v-text="source.contact"></div>
    <label><?=_('Birth')?></label>
    <div v-text="fdate(source.naissance)"></div>
  </div>
  <div class="bbn-w-100 bbn-top-space">
    <div class="bbn-header bbn-c"><?=_("Today")?></div>
    <div class="bbn-white bbn-c"
         :style="{backgroundColor: absenceColor}"
         v-html="absenceText"
    ></div>
  </div>
</div>