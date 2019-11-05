<div v-if="selected" 
     class="bbn-right-xsspace bbn-bottom-xsspace bbn-left-xsspace"
>
  <bbn-scroll>
    <bbn-initial v-for="(ev, i) in source.events" 
                 :user-name="getEmploye(ev.employe)"
                 :key="i"
                 class="bbn-xsmargin"
                 :width="20"
    ></bbn-initial>
  </bbn-scroll>
</div>
<div v-else>
  <bbn-scroll>
    <ul class="bbn-ul">
      <li v-for="ev in source.events">
        <component :is="$options.components.item" :source="ev"></component>
      </li>
    </ul>
  </bbn-scroll>
</div>
