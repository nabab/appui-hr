<div  style="margin: 0 .2em .2em .2em">
  <div v-if="isWorkingDay && (source.events.length === 1)"
       class="bbn-overlay bbn-middle"
  >
    <i class="bbn-xxxl nf nf-mdi-account_convert"></i>
  </div>
  <bbn-scroll v-else>
    <bbn-initial v-for="(ev, i) in source.events" 
                 :user-name="getEmploye(ev.id_employe)"
                 :key="i"
                 style="margin: .1rem"
                 :width="20"
                 v-if="ev.id_employe"
    ></bbn-initial>
</bbn-scroll>
</div>
