<div class="bbn-grid-fields bbn-l">
  <div>
    <span class="label-icon">
      <i class="nf nf-fa-user label-icon"></i>
    </span>   
    <?=_('Employé')?>
  </div>
  <a :href="'hr/card/' + source.id_employe" 
             v-text="employee"
  ></a>
  
  <div>
    <span class="label-icon">
      <i class="nf nf-mdi-beach label-icon"></i>
    </span>  
    <?=_('Pour')?>
  </div>
  <div v-text="type" 
       :style="{color: color}"
  ></div>
  
  <div>
    <span class="label-icon">
      <i class="nf nf-fa-calendar label-icon"></i>
    </span>  
    <?=_('Du/Au')?>
  </div>
  <div>
    <span v-text="start"></span>
    <i class="bbn-hsmargin nf nf-fa-long_arrow_right"></i>
    <span v-text="end"></span>
  </div>

  <div v-if="source.chantier">
    <span class="label-icon">
      <i class="nf nf-fa-building label-icon"></i>
    </span> 
    <?=_('Chantier')?>
  </div>
  <div v-if="source.chantier"
       class="chantier"
  >
    <a :href="linkFiche"
       v-text="source.chantier"
    ></a>
  </div>
  
  <div>
    <span class="label-icon">
      <i class="nf nf-fa-map_signs label-icon"></i>
    </span>  
    <?=_('Adresse')?>
  </div>
  <div class="chantier">
    <a :href="linkFiche"
       v-html="fulladdress"
    ></a>
  </div>

</div>