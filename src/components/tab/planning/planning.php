<div class="appui-hr-tab-planning bbn-flex-height">
  <div v-if="!isYearMode && fromJSON && !isBefore"
       class="bbn-spadded bbn-alt-background"
  >
    <div class="bbn-flex-width bbn-vmiddle">
      <div>
        <bbn-button icon="nf nf-fa-refresh"
                    @click="refreshJSON"
        ><?=_('Regenerate')?></bbn-button>
        <bbn-button icon="nf nf-fa-calendar_check_o"
                    @click="approveJSON"
        ><?=_('Approve')?></bbn-button>
      </div>
      <div class="bbn-flex-fill bbn-c">
        <strong class="bbn-large bbn-red bbn-hmargin"><?=_('PLAN NOT APPROVED')?></strong>
        <i class="nf nf-fa-clock_o"></i><span class="bbn-hsmargin" v-text="lastEdit"></span>
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
            ></bbn-calendar>
          </div>
        </div>
        <bbn-calendar v-else
                      :source="root + 'data/planning/month'"
                      @selected="changeSelected"
                      ref="calendar"
                      :item-details="true"
                      item-component="ami-hr-tab-planning-day"
                      @mounted="calendarSelected = $refs.calendar"
                      :item-title="getTitle"
                      :title-action="changeMode"
                      :date="calendarSelected ? calendarSelected.date : ''"
                      @dataReceived="afterLoadDays"
                      @next="setIsBefore"
                      @prev="setIsBefore"
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
</div>

