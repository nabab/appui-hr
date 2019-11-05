<div>
  <div v-for="(ent, idx) in entities" class="bbn-grid-fields">
    <div v-if="ent.nom">
      <span class="label-icon">
        <i class="nf nf-fa-building_o label-icon"></i>
      </span>  
      <?=_('Nom')?>
    </div>
    <div class="chantier" v-if="ent.nom">
      <a :href="'chantier/fiche/' + ent.id"
         v-text="ent.nom"
      ></a>
    </div>

    <div>
      <span class="label-icon">
        <i class="nf nf-fa-map_signs label-icon"></i>
      </span>  
      <?=_('Adresse')?>
    </div>
    <div class="chantier">
      <a :href="'chantier/fiche/' + ent.id"
         v-html="ent.adresse"
      ></a>
    </div>
		
		<div>
      <span class="label-icon">
        <i class="nf nf-fa-clock_o label-icon"></i>
      </span>  
      <?=_('h/sem')?>
    </div>
    <div v-text="hsem(ent)"></div>    
  </div>
  <div class="bbn-header" style="margin-top: 1em">
    <i class="nf nf-fa-clock_o"></i> TOTAL H/SEM: <span v-text="htotal"></span>
  </div>
</div>