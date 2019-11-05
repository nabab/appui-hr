<div class="ami-hr-tab-holidays">
  <bbn-tabnav class="bbn-overlay">
    <bbns-container url="planning"
              :static="true"
              :load="false"
              icon="nf nf-oct-calendar"
              title="<?=_('Planning des vacances')?>"
              :notext="true"
              component="ami-hr-tab-holidays-planning"
    ></bbns-container>
    <bbn-container url="list"
              :static="true"
              :load="false"
              icon="nf nf-fa-list"
              title="<?=_('Liste des vacances')?>"
              :notext="true"
    >
      <bbn-table ref="table"
                source="data/hr/holidays"
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
      >
        <bbns-column title="<?=_('Nom')?>"
                      field="id_employe"
                      :render="renderEmploye"
        ></bbns-column>
        <bbns-column title="<?=_('Du')?>"
                      field="start"
                      type="date"
                      cls="bbn-c"
                      width="100"
        ></bbns-column>
        <bbns-column title="<?=_('Au')?>"
                      field="end"
                      type="date"
                      cls="bbn-c"
                      width="100"
        ></bbns-column>
        <bbns-column title="<?=_('Type')?>"
                      field="id_type"
                      :source="absences"
                      cls="bbn-c"
                      width="200"
        ></bbns-column>
        <bbns-column title="<?=_('Remplaçant(s)')?>"
                     field="employes"
										 :render="renderEmployes"
        ></bbns-column>
        <bbns-column title="<?=_('Note')?>"
                      field="note"
                      :filterable="false"
                      cls="bbn-c",
                      :render="renderNote"
                      :width="50"
        ></bbns-column>
        <bbns-column :buttons="[{
                        text: '<?=_("Regarde la carte d\'employé")?>',
                        icon: 'nf nf-fa-address_card',
                        notext: true,
                        action: openCard
                      }]"
                      :width="60"
                      cls="bbn-c"
        ></bbns-column>
      </bbn-table>
    </bbn-container>
  </bbn-tabnav>
</div>
