<div class="appui-hr-card-tab-holidays">
  <bbn-router class="bbn-overlay"
              :nav="true"
              :autoload="false"
  >
    <bbns-container url="planning"
                    :fixed="true"
                    :load="false"
                    icon="nf nf-oct-calendar"
                    label="<?= _('Holidays Planning') ?>"
                    :notext="true"
                    component="appui-hr-card-tab-holidays-planning"
                    v-if="source.tabs.holidays.tabs.planning"
    ></bbns-container>
    <bbn-container url="list"
                   :fixed="true"
                   :load="false"
                   icon="nf nf-fa-list"
                   label="<?= _('Holidays List') ?>"
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
                  dir: 'DESC'
                }, {
                  field: 'end',
                  dir: 'DESC'
                }]"
                :toolbar="$options.component.toolbar"
                :filters="{conditions:[{field: 'id_staff', value: source.id}]}"
                :trClass="colorRow"
      >
        <bbns-column label="<?= _('Name') ?>"
                     field="id_staff"
                     :invisible="true"
        ></bbns-column>
        <bbns-column label="<?= _('From') ?>"
                     field="start"
                     type="date"
                     cls="bbn-c"
                     width="100"
                     :export="{
                       format: 'Y-m-d'
                     }"
        ></bbns-column>
        <bbns-column label="<?= _('To') ?>"
                     field="end"
                     type="date"
                     cls="bbn-c"
                     width="100"
                     :export="{
                       format: 'Y-m-d'
                     }"
        ></bbns-column>
        <bbns-column label="<?= _('Type') ?>"
                     field="id_type"
                     :source="absences"
                     cls="bbn-c"
                     width="200"
        ></bbns-column>
        <bbns-column label="<?= _('Status') ?>"
                     field="status"
                     :source="hr.holidaysStatus"
                     cls="bbn-c"
                     width="180"
                     :render="renderStatus"
        ></bbns-column>
        <bbns-column label="<?= _('Substitute(s)') ?>"
                     field="substitutes"
									   :render="renderSub"
        ></bbns-column>
        <bbns-column label="<?= _('Note') ?>"
                     field="note"
                     :filterable="false"
                     cls="bbn-c",
                     :render="renderNote"
                     :width="50"
        ></bbns-column>
        <bbns-column :buttons="buttons"
                     :width="150"
                     cls="bbn-c"
                     v-if="hr.source.perms.write"
        ></bbns-column>
      </bbn-table>
    </bbn-container>
  </bbn-router>
</div>
