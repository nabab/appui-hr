<div class="appui-hr-tab-planning bbn-overlay">
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
          ></bbn-calendar>
        </div>
      </div>
      <bbn-calendar v-else
                    :source="root + 'data/planning/month'"
                    @selected="changeSelected"
                    ref="calendar"
                    :item-details="true"
                    item-component="ami-hr-tab-planning-day"
                    @hook:mounted="calendarSelected = getRef('calendar')"
                    :item-title="getTitle"
                    :title-action="changeMode"
                    :date="calendarSelected ? calendarSelected.date : ''"
                    @dataReceived="afterLoadDays"
                    @next="setIsBefore"
                    @prev="setIsBefore"
                    :selection="true"
                    :show-loading="true"
      ></bbn-calendar>
    </bbn-pane>
    <bbn-pane :collapsed="!selected">
      <div class="bbn-100 bbn-block bbn-flex-height">
        <div class="bbn-header bbn-flex-width">
          <bbn-button icon="nf nf-fa-calendar_plus_o"
                      @click="addEvent"
                      title="<?=_('Add')?>"
                      v-if="!isBefore"
                      :notext="true"
          ></bbn-button>
          <div class="bbn-flex-fill bbn-middle">
            <i class="nf nf-mdi-calendar_today bbn-hsmargin"></i>
            <span v-text="dayText"></span>
          </div>
          <bbn-button icon="nf nf-fa-window_close"
                      @click="changeSelected(false, false)"
                      title="<?=_('Back to the calendar')?>"
                      :notext="true"
          ></bbn-button>
        </div>
        <div class="bbn-flex-fill bbn-spadded">
          <appui-hr-tab-planning-event :source="events" ref="events"></appui-hr-tab-planning-event>
        </div>
      </div>
    </bbn-pane>
  </bbn-splitter>
</div>

