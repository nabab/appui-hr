<div class="bbn-spadded bbn-widget">
  <div class="bbn-flex-width">
    <bbn-initial :user-name="source.employe"
                 :width="50"
                 font-size="1.5em"
    ></bbn-initial>
    <div class="bbn-hsmargin" 
         :style="{width: '1em', height: '50px', backgroundColor: color}"></div>
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
        <strong><span class="bbn-hsmargin" v-text="source.employe"></span></strong>
      </div>
      <div v-if="source.note">
        <i class="nf nf-fa-comment_o"></i>
        <span class="bbn-hsmargin" v-text="source.note"></span>
      </div>
    </div>  
    <div class="bbn-xl bbn-vmiddle">
      <i class="nf nf-fa-address_card_o bbn-p"
         @click="openCard"
         title="<?=_("Regarde la carte d'employé")?>"
      ></i>
      <i class="nf nf-fa-edit bbn-p bbn-hsmargin"
         @click="edit"
         title="<?=_('Modifier')?>"
      ></i>
      <i class="nf nf-fa-trash_o bbn-p"
         @click="remove"
         title="<?=_('Supprimer')?>"
      ></i>
    </div>
  </div>
</div>