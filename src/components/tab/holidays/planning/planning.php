<div class="ami-hr-tab-holidays-planning bbn-100">
  <bbn-splitter ref="splitter">
    <bbn-pane :scrollable="isYearMode"
              ref="calendarContainer"
    >
      <div v-if="isYearMode"
           class="planning-year-mode bbn-w-100"
      >
        <div class="bbn-flex-width planning-year-mode-header bbn-header bbn-xspadded">
          <bbn-button icon="nf nf-fa-angle_left"
                      @click="prevYear"
                      title="<?=_('Année précédente')?>"
                      :notext="true"
          ></bbn-button>
          <div class="bbn-flex-fill bbn-middle">
            <i class="nf nf-fa-calendar_o bbn-hsmargin bbn-large"></i>
            <strong v-text="'<?=_('Année')?> ' + currentYear"></strong>
          </div>
          <bbn-button icon="nf nf-fa-angle_right"
                      @click="nextYear"
                      title="<?=_('Année prochaine')?>"
                      :notext="true"
          ></bbn-button>
        </div>
        <div class="planning-year-mode-calendars">
          <bbn-calendar v-for="idx in 12"
                        :date="currentYear + '-' + (idx.toString().length === 1 ? '0' + idx : idx) + '-01'"
                        :arrows="false"
                        :key="'hr-calendar-' + idx"
                        :source="'data/hr/events/' + idx"
                        :item-title="getTitle"
                        :day-padding="true"
                        event-icon="nf nf-fa-user"
                        :selection="true"
                        v-model="selected"
                        :title-action="changeMode"
          ></bbn-calendar>
        </div>
      </div>
      <bbn-calendar v-else
                    source="data/hr/events"
                    ref="calendar"
                    :item-details="true"
                    item-component="ami-hr-tab-holidays-planning-day"
                    :extra-items="true"
                    @mounted="calendarSelected = $refs.calendar"
                    :item-title="getTitle"
                    :date="calendarSelected ? calendarSelected.date : ''"
                    :selection="true"
                    v-model="selected"
                    :title-action="changeMode"
      ></bbn-calendar>
    </bbn-pane>
    <bbn-pane :collapsed="!selected">
      <div class="bbn-100 bbn-block bbn-widget bbn-flex-height">
        <div class="bbn-header bbn-flex-width bbn-spadded">
          <bbn-button icon="nf nf-fa-calendar_plus_o"
                      @click="addEvent"
                      title="<?=_('Ajouter')?>"
                      :notext="true"
          ></bbn-button>
          <div class="bbn-flex-fill bbn-middle">
            <i class="nf nf-mdi-calendar_today bbn-hsmargin"></i>
            <span v-text="dayText"></span>
          </div>
          <bbn-button icon="nf nf-fa-window_close"
                      @click="changeSelected('', false)"
                      title="<?=_('Retour au calendrier')?>"
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
                     }"></div>
                <span v-text="absence.text"></span>
              </div>
            </div>
          </div>
          <bbn-list :source="events"
                    component="ami-hr-tab-holidays-planning-event"
          ></bbn-list>
        </div>
      </div>
    </bbn-pane>
  </bbn-splitter>
</div>

