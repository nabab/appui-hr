<div class="appui-hr-tab-planning bbn-overlay">
  <div class="bbn-flex-height">
    <div>
      <div class="bbn-header bbn-spadded bbn-flex-width bbn-no-border-bottom">
        <div class="bbn-flex-fill">
          <bbn-button icon="nf nf-fa-file_excel_o"
                      @click="exportExcel"
                      v-if="!isYearMode"
          ><?=_('Excel')?></bbn-button>
        </div>
        <div>
          <span><?=_('Filter by staff')?>: </span>
          <bbn-dropdown :source="staff"
                        v-model="currentStaff"
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
              class="appui-hr-tab-planning-year-mode bbn-w-100"
          >
            <div class="bbn-flex-width appui-hr-tab-planning-year-mode-header bbn-header bbn-xspadded">
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
            <div class="appui-hr-tab-planning-year-mode-calendars">
              <bbn-calendar v-for="idx in 12"
                            :date="currentYear + '-' + (idx.toString().length === 1 ? '0' + idx : idx) + '-01'"
                            :arrows="false"
                            :key="'appui-hr-calendar-' + idx"
                            :source="root + 'data/planning/month'"
                            :item-title="getTitle"
                            :title-action="changeMode"
                            :day-padding="true"
                            event-icon="nf nf-fa-user"
                            :selection="true"
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
              <bbn-calendar :source="root + 'data/planning/month'"
                            @selected="changeSelected"
                            ref="calendar"
                            :item-details="true"
                            :item-component="hr.source.tabs.planning.components.day"
                            @hook:mounted="calendarSelected = getRef('calendar')"
                            :item-title="getTitle"
                            :title-action="changeMode"
                            :date="calendarSelected ? calendarSelected.date : ''"
                            :selection="true"
                            :show-loading="true"
                            :extra-items="true"
                            :filterable="true"
                            :filters="currentFilters"
              ></bbn-calendar>
            </div>
            <div class="bbn-xspadded bbn-r bbn-widget">
              <bbn-button icon="nf nf-fa-refresh"
                          @click="() => {getRef('calendar').refresh()}"
                          :notext="true"
                          text="<?=_('Refresh')?>"
              ></bbn-button>
            </div>
          </div>
        </bbn-pane>
        <bbn-pane :collapsed="!selected">
          <div class="bbn-100 bbn-block bbn-flex-height">
            <div class="bbn-header bbn-flex-width bbn-xspadded">
              <bbn-button icon="nf nf-fa-calendar_plus_o"
                          @click="addEvent"
                          title="<?=_('Add')?>"
                          :notext="true"
              ></bbn-button>
              <div class="bbn-flex-fill bbn-middle">
                <i class="nf nf-mdi-calendar_today bbn-hsmargin bbn-large"></i>
                <strong v-text="dayText"></strong>
              </div>
              <bbn-button icon="nf nf-fa-window_close"
                          @click="changeSelected(false, false)"
                          title="<?=_('Back to the calendar')?>"
                          :notext="true"
              ></bbn-button>
            </div>
            <div class="bbn-flex-fill bbn-spadded">
              <component :is="hr.source.tabs.planning.components.events"
                         :source="events"
                         ref="events"
              ></component>
            </div>
          </div>
        </bbn-pane>
      </bbn-splitter>
    </div>
  </div>
</div>

