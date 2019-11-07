<div class="appui-hr-tab-holidays">
  <bbn-tabnav class="bbn-overlay">
    <bbns-container url="planning"
              :static="true"
              :load="false"
              icon="nf nf-oct-calendar"
              title="<?=_('Holidays Planning')?>"
              :notext="true"
              component="appui-hr-tab-holidays-planning"
    ></bbns-container>
    <bbn-container url="list"
              :static="true"
              :load="false"
              icon="nf nf-fa-list"
              title="<?=_('Holidays List')?>"
              :notext="true"
    >
      <bbn-table ref="table"
                :source="root + 'data/holidays'"
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
        <bbns-column title="<?=_('Name')?>"
                      field="id_employe"
                      :render="renderName"
        ></bbns-column>
        <bbns-column title="<?=_('From')?>"
                      field="start"
                      type="date"
                      cls="bbn-c"
                      width="100"
        ></bbns-column>
        <bbns-column title="<?=_('To')?>"
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
        <bbns-column title="<?=_('Substitute(s)')?>"
                     field="employes"
										 :render="renderSub"
        ></bbns-column>
        <bbns-column title="<?=_('Note')?>"
                      field="note"
                      :filterable="false"
                      cls="bbn-c",
                      :render="renderNote"
                      :width="50"
        ></bbns-column>
        <bbns-column :buttons="buttons"
                      :width="60"
                      cls="bbn-c"
        ></bbns-column>
      </bbn-table>
    </bbn-container>
  </bbn-tabnav>
</div>
