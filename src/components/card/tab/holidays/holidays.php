<div class="appui-hr-card-tab-holidays">
  <bbn-router class="bbn-overlay"
              :nav="true"
              :autoload="false"
  >
    <bbns-container url="planning"
                    :static="true"
                    :load="false"
                    icon="nf nf-oct-calendar"
                    title="<?=_('Holidays Planning')?>"
                    :notext="true"
                    component="appui-hr-card-tab-holidays-planning"
                    v-if="source.tabs.holidays.tabs.planning"
    ></bbns-container>
    <bbn-container url="list"
                   :static="true"
                   :load="false"
                   icon="nf nf-fa-list"
                   title="<?=_('Holidays List')?>"
                   :notext="true"
                   v-if="source.tabs.holidays.tabs.list"
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
                :toolbar="$options.component.toolbar"
                :filters="{conditions:[{field: 'id_staff', value: source.id}]}"
      >
        <bbns-column title="<?=_('Name')?>"
                     field="id_staff"
                     :hidden="true"
        ></bbns-column>
        <bbns-column title="<?=_('From')?>"
                     field="start"
                     type="date"
                     cls="bbn-c"
                     width="100"
                     :export="{
                       format: 'Y-m-d'
                     }"
        ></bbns-column>
        <bbns-column title="<?=_('To')?>"
                     field="end"
                     type="date"
                     cls="bbn-c"
                     width="100"
                     :export="{
                       format: 'Y-m-d'
                     }"
        ></bbns-column>
        <bbns-column title="<?=_('Type')?>"
                     field="id_type"
                     :source="absences"
                     cls="bbn-c"
                     width="200"
        ></bbns-column>
        <bbns-column title="<?=_('Status')?>"
                     field="status"
                     :source="hr.holidaysStatus"
                     cls="bbn-c"
                     width="180"
                     :render="renderStatus"
        ></bbns-column>
        <bbns-column title="<?=_('Substitute(s)')?>"
                     field="substitutes"
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
                     :width="150"
                     cls="bbn-c"
        ></bbns-column>
      </bbn-table>
    </bbn-container>
  </bbn-router>
</div>
