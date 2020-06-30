<div class="appui-hr-tab-holidays-planning bbn-overlay">
  <div class="bbn-flex-height">
    <div>
      <div class="bbn-header bbn-spadded bbn-flex-width bbn-no-border-bottom">
        <div class="bbn-flex-fill">
          <!-- <bbn-button icon="nf nf-fa-file_excel_o"
                      @click="exportExcel"
                      v-if="!isYearMode"
          ><?=_('Excel')?></bbn-button> -->
        </div>
        <div>
          <span><?=_('Staff')?>: </span>
          <bbn-dropdown :source="staff"
                        v-model="currentStaff"
                        :nullable="true"
          ></bbn-dropdown>
        </div>
        <div class="bbn-left-space">
          <span><?=_('Status')?>: </span>
          <bbn-dropdown :source="hr.holidaysStatus"
                        v-model="currentStatus"
                        :nullable="true"
          ></bbn-dropdown>
        </div>
      </div>
    </div>
    <div class="bbn-flex-fill">
      <bbn-splitter ref="splitter">
        <bbn-pane :scrollable="isYearMode"
                  ref="calendarContainer"
        >
          <div v-if="isYearMode"
              class="appui-hr-tab-holidays-planning-year-mode bbn-w-100"
          >
            <div class="bbn-flex-width appui-hr-tab-holidays-planning-year-mode-header bbn-header bbn-xspadded">
              <bbn-button icon="nf nf-fa-angle_left"
                          @click="prevYear"
                          title="<?=_('Previous year')?>"
                          :notext="true"
              ></bbn-button>
              <div class="bbn-flex-fill bbn-middle">
                <i class="nf nf-fa-calendar_o bbn-hsmargin bbn-large"></i>
                <strong v-text="'<?=_('Year')?> ' + currentYear"></strong>
              </div>
              <bbn-button icon="nf nf-fa-angle_right"
                          @click="nextYear"
                          title="<?=_('Next year')?>"
                          :notext="true"
              ></bbn-button>
            </div>
            <div class="appui-hr-tab-holidays-planning-year-mode-calendars">
              <bbn-calendar v-for="idx in 12"
                            :date="currentYear + '-' + (idx.toString().length === 1 ? '0' + idx : idx) + '-01'"
                            :arrows="false"
                            :key="'hr-calendar-' + idx"
                            :source="root + 'data/events/' + idx"
                            :item-title="getTitle"
                            :day-padding="true"
                            event-icon="nf nf-fa-user"
                            :selection="true"
                            v-model="selected"
                            :title-action="changeMode"
                            @selected="changeSelected"
                            :filters="currentFilters"
                            :filterable="true"
              ></bbn-calendar>
            </div>
          </div>
          <div v-else
                class="bbn-flex-height"
          >
            <div class="bbn-flex-fill">
              <bbn-calendar :source="root + 'data/events'"
                            ref="calendar"
                            :item-details="true"
                            item-component="appui-hr-tab-holidays-planning-day"
                            :extra-items="true"
                            @hook:mounted="calendarSelected = $refs.calendar"
                            :item-title="getTitle"
                            :date="calendarSelected ? calendarSelected.date : ''"
                            :selection="true"
                            v-model="selected"
                            :title-action="changeMode"
                            :filters="currentFilters"
                            :filterable="true"
              ></bbn-calendar>
          </div>
          <div class="bbn-xspadded bbn-r bbn-widget">
            <bbn-button icon="nf nf-fa-refresh"
                        @click="() => {fullRefresh()}"
                        :notext="true"
                        text="<?=_('Refresh')?>"
            ></bbn-button>
          </div>
        </div>
        </bbn-pane>
        <bbn-pane :collapsed="!selected">
          <div class="bbn-100 bbn-block bbn-widget bbn-flex-height">
            <div class="bbn-header bbn-flex-width bbn-xspadded">
              <bbn-button icon="nf nf-fa-calendar_plus_o"
                          @click="addEvent"
                          title="<?=_('Add')?>"
                          :notext="true"
                          v-if="hr.source.perms.write"
              ></bbn-button>
              <div class="bbn-flex-fill bbn-middle">
                <i class="nf nf-mdi-calendar_today bbn-hsmargin"></i>
                <span v-text="dayText"></span>
              </div>
              <bbn-button icon="nf nf-fa-window_close"
                          @click="changeSelected('', false)"
                          title="<?=_('Back to calendar')?>"
                          :notext="true"
              ></bbn-button>
            </div>
            <div class="bbn-flex-fill bbn-spadded">
              <div class="bbn-widget bbn-content bbn-spadded"
                  style="display: grid; grid-template-columns: repeat(3, auto)"
              >
                <div v-for="absence in absences">
                  <div class="bbn-vmiddle"
                      style="justify-content: center"
                  >
                    <div class="bbn-hsmargin"
                        :style="{
                          backgroundColor: absence.color,
                          height: '1em',
                          width: '2em',
                          border: '1px solid'
                        }"
                    ></div>
                    <span v-text="absence.text"></span>
                  </div>
                </div>
              </div>
              <bbn-list :source="events"
                        component="appui-hr-tab-holidays-planning-event"
                        ref="events"
                        :filterable="true"
                        :filters="currentFilters"
              ></bbn-list>
            </div>
          </div>
        </bbn-pane>
      </bbn-splitter>
    </div>
  </div>
</div>

