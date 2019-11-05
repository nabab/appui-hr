<div class="ami-hr-tab-entities">
  <bbn-table ref="table"
             source="data/hr/entities/list"
             class="bbn-100"
             :sortable="true"
             :pageable="true"
             :editable="false"
             :filterable="true"
             :limit="50"
             :order="[{
               field: 'start',
               dir: 'ASC'
              }, {
               field: 'end',
               dir: 'ASC'
              }]"
             :showable="true"
             :groupable="true"
             :group-by="0"
             :expanded="true"
  >
     <bbns-column title="<?=_('Nom')?>"
                  field="id_employe"
                  :render="renderEmployee"
     ></bbns-column>
     <bbns-column title="<?=_('Start')?>"
                  field="start"
                  type="date"
                  cls="bbn-c"
                  width="100"
     ></bbns-column>
     <bbns-column title="<?=_('End')?>"
                  field="end"
                  type="date"
                  cls="bbn-c"
                  width="100"
     ></bbns-column>
     <bbns-column title="<?=_('Groupe')?>"
                  field="id_group"
                  :source="groups"
                  :hidden="true"
     ></bbns-column>
     <bbns-column title="<?=_('Chantier')?>"
                  field="chantier"
                  :render="renderChantier"
     ></bbns-column>
     <bbns-column title="<?=_('Adresse')?>"
                  field="chantier_adresse"
                  :render="renderAdresse"
     ></bbns-column>
     <!-- <bbns-column title="<?=_('H/Sem')?>"
                  field="hour"
                  :width="80"
                  cls="bbn-c"
                  editor="bbn-numeric"
                  :options="{step: 0.5, min: 1}"
     ></bbns-column> -->
     <bbns-column :buttons="[{
                    text: '<?=_("Remplacer l\'employé en mode rapide")?>',
                    icon: 'nf nf-fa-retweet',
                    notext: true,
                    action: replaceEmployee
                  }, {
                    text: '<?=_("Remplacer l\'employé en mode détaillé")?>',
                    icon: 'nf nf-fa-calendar',
                    notext: true,
                    action: replaceEmployeePlanning
                  }]"
                  :width="100"
                  cls="bbn-c"
     ></bbns-column>
  </bbn-table>
</div>
