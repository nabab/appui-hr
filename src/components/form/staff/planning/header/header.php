<div v-if="calendar" class="bbn-spadded">
  <div class="bbn-flex-width">
    <bbn-button v-if="calendar.arrowsYear"
                icon="nf nf-fa-angle_double_left"
                @click="calendar.prevYear"
                title="<?=_('Année précédente')?>"
                class="bbn-button-icon-only"
    ></bbn-button>
    <bbn-button v-if="calendar.arrowsMonth"
                icon="nf nf-fa-angle_left"
                @click="calendar.prevMonth"
                title="<?=_('Mois précédent')?>"
                class="bbn-button-icon-only"
    ></bbn-button>
    <div class="bbn-flex-fill bbn-middle">
      <i class="nf nf-fa-calendar bbn-hsmargin bbn-p bbn-large"
         @click="changeMode"
         title="<?=_('Changer de vue')?>"
      ></i>
      <strong v-text="calendar.monthYear"></strong>
    </div>
    <bbn-button v-if="calendar.arrowsMonth"
                icon="nf nf-fa-angle_right"
                @click="calendar.nextMonth"
                title="<?=_('Mois prochain')?>"
                class="bbn-button-icon-only"
    ></bbn-button>
    <bbn-button v-if="calendar.arrowsYear"
                icon="nf nf-fa-angle_double_right"
                @click="calendar.nextYear"
                title="<?=_('Année prochaine')?>"
                class="bbn-button-icon-only"
    ></bbn-button>
  </div>
</div>