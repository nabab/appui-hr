<div class="ami-hr-tab-planning-day bbn-right-xsspace bbn-bottom-xsspace bbn-left-xsspace">
  <bbn-scroll>
    <bbn-initial v-for="(s, i) in staff" 
                 :user-name="s"
                 :key="i"
                 class="bbn-xsmargin"
                 :width="20"
    ></bbn-initial>
  </bbn-scroll>
</div>
