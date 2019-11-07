<div class="ami-hr-form-staff-planning bbn-overlay">
  <div v-if="isLoading" class="bbn-overlay bbn-middle">
    <bbn-loader loading-text="<?=_('Chargement')?>"></bbn-loader>
  </div>
  <bbn-form v-else
            class="bbn-overlay"
            :scrollable="false"
            :source="formSource"
            action="actions/hr/holidays/replace"
            :data="{
              id_entity: source.id_entity
            }"
            @success="afterSubmit"
  >
    <bbn-splitter ref="splitter">
      <bbn-pane ref="calendarContainer">
        <bbn-calendar :source="events"
                      @selected="changeSelected"
                      ref="calendar"
                      :day-details="true"
                      details-component="ami-hr-form-staff-planning-day"
                      :title-details="getTitle"
                      header-component="ami-hr-form-staff-planning-header"
                      :days-range="daysRange"
                      
        ></bbn-calendar>
      </bbn-pane>
      <bbn-pane :collapsed="!selected">
        <div class="bbn-100 bbn-block bbn-flex-height">
          <div class="bbn-header bbn-flex-width">
            <bbn-button icon="nf nf-fa-calendar_plus_o"
                        @click="addEvent"
                        title="<?=_('Ajouter')?>"
                        class="bbn-button-icon-only"
            ></bbn-button>
            <div class="bbn-flex-fill bbn-middle">
              <i class="nf nf-mdi-calendar_today bbn-hsmargin"></i>
              <span v-text="dayText"></span>
            </div>
            <bbn-button icon="nf nf-fa-window_close"
                        @click="changeSelected(false)"
                        title="<?=_('Retour au calendrier')?>"
                        class="bbn-button-icon-only"
            ></bbn-button>
          </div>
          <div class="bbn-flex-fill">
            <div class="bbn-flex-height">
              <div class="bbn-spadded" v-if="originalHours">
                <strong><span v-text="nom"></span>: <span v-text="originalHours"></span> <?=_('heures')?></strong>
              </div>
              <div class="bbn-flex-fill">
                <bbn-table :source="events"
                          :order="[{
                            field: 'nom',
                            dir: 'ASC'
                          }]"
                          ref="table"
                          editable="popup"
                          :editor="$options.components.form"
                          :filterable="false"
                          :filters="{
                            logic: 'AND',
                            conditions: [{
                              field: 'start',
                              operator: '>=',
                              value: selected + ' 00:00:00'
                            }, {
                              field: 'end',
                              operator: '<=',
                              value: selected + ' 23:59:59'
                            }, {
                              field: 'id_employe',
                              operator: '!=',
                              value: source.id_employe
                            }]  
                          }"
                          :pageable="false"
                >
                  <bbns-column title="<?=_('Employe')?>"
                              field="id_employe"
                              :source="employes"
                  ></bbns-column>
                  <bbns-column title="<?=_('Heures')?>"
                              field="hour"
                              :width="100"
                              cls="bbn-c"
                              :default="0.5"
                  ></bbns-column>
                  <bbns-column :buttons="[{
                                  text: '<?=_('Modifier')?>',
                                  notext: true,
                                  action: editEvent,
                                  icon: 'nf nf-fa-edit'
                                }, {
                                  text: '<?=_('Supprimer')?>',
                                  notext: true,
                                  action: removeEvent,
                                  icon: 'nf nf-fa-trash'
                                }]"
                                :width="90"
                                cls="bbn-c"
                  ></bbns-column>
                </bbn-table>
              </div>
            </div>
          </div>
        </div>
      </bbn-pane>
    </bbn-splitter>
  </bbn-form>
</div>