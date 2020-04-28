<template lang="pug">
  section(
    :class="{ widget: true, className, collapsed: state === 'collapse', fullscreened: state === 'fullscreen', loading: fetchingData }",
    ref='widget'
  )
    h5.title(v-if="title && typeof title === 'string' && !customHeader") {{title}}
    header.title(v-if='title && customHeader', v-html='title')
    .widgetControls.widget-controls(v-if='!customControls && mainControls')
      a(v-if='settings || settingsInverse', href='#')
        i.la.la-cog
      a(@click='loadWidgster($event)', v-if='refresh', href='#', :id='`reloadId-${randomId}`')
        strong.text-gray-light(v-if="typeof refresh === 'string'") {{refresh}}
        i.la.la-refresh(v-else='')
          b-tooltip(v-if='showTooltip', :placement='tooltipPlacement', :target='`reloadId-${randomId}`')
            | Reload
      a(@click="changeState($event, 'fullscreen')", v-if="fullscreen && state !== 'fullscreen'", href='#', :id='`fullscreenId-${randomId}`')
        i.glyphicon.glyphicon-resize-full
        b-tooltip(v-if='showTooltip', :placement='tooltipPlacement', :target='`fullscreenId-${randomId}`')
          | Fullscreen
      a(@click="changeState($event, 'default')", v-if="fullscreen && state === 'fullscreen'", href='#', :id='`restoreId-${randomId}`')
        i.glyphicon.glyphicon-resize-small
        b-tooltip(v-if='showTooltip', :placement='tooltipPlacement', :target='`restoreId-${randomId}`')
          | Restore
      span(v-if="collapse && state !== 'collapse'")
        a(href='#', @click="changeState($event, 'collapse')", :id='`collapseId-${randomId}`')
          i.la.la-angle-down
          b-tooltip(v-if='showTooltip', :placement='tooltipPlacement', :target='`collapseId-${randomId}`')
            | Collapse
      span(v-if="collapse && state === 'collapse'")
        a(href='#', @click="changeState($event, 'default')", :id='`expandId-${randomId}`')
          i.la.la-angle-up
          b-tooltip(v-if='showTooltip', :placement='tooltipPlacement', :target='`expandId-${randomId}`')
            | Expand
      a(v-if='close', href='#', @click='closeWidget($event)', :id='`closeId-${randomId}`')
        strong.text-gray-light(v-if="typeof refresh === 'string'") {{close}}
        i.la.la-remove(v-else='')
        b-tooltip(v-if='showTooltip', :placement='tooltipPlacement', :target='`closeId-${randomId}`')
          | Close
    .widgetControls.widget-controls(v-if='customControls', v-html='customControls', ref='customControlsRef')
    div(
      :class='`widgetBody widget-body ${bodyClass}`',
      ref='widgetBodyRef',
      :style="{display: state === 'collapse' ? 'none' : ''}"
    )
      loader(v-if='fetchingData && showLoader', :class="'widget-loader'", :size='40')
      slot(v-else='')

</template>

<script>
import Loader from '../Loader/Loader';

export default {
  name: 'Widget',
  data: function() {
    return {
      state: this.collapsed ? 'collapse' : 'default'
    }
  },
  props: {
    customHeader: { type: Boolean, default: false },
    tooltipPlacement: { default: 'top' },
    showTooltip: { type: Boolean, default: false },
    close: { type: [Boolean, String], default: false },
    fullscreen: { type: [Boolean, String], default: false },
    collapse: { type: [Boolean, String], default: false },
    settings: { type: [Boolean, String], default: false },
    settingsInverse: { type: Boolean, default: false },
    refresh: { type: [Boolean, String], default: false },
    className: { default: '' },
    title: { default: '' },
    customControls: { default: null },
    bodyClass: { default: '' },
    options: { default: () => ({}) },
    fetchingData: {type: Boolean, default: false},
    showLoader: {type: Boolean, default: true},
    collapsed: {type: Boolean, default: false},
    autoload: {type: [Boolean, Number], default: false}
  },
  components: { Loader },
  computed: {
    randomId() {
      return Math.floor(Math.random() * 100);
    },
    mainControls() {
      return !!(this.close || this.fullscreen || this.collapse
        || this.refresh || this.settings || this.settingsInverse);
    },
  },
  mounted() {
    if (this.autoload && this.$listeners && this.$listeners.load) {
      this.loadWidgster();
      if (typeof this.autoload === 'number') {
        setInterval(() => {this.loadWidgster()}, this.autoload);
      }
    }
    if (this.customControls) {
      let close = this.$refs.customControlsRef.querySelector('[control=close]');
      close && close.addEventListener('click', this.closeWidget);
      let collapse = this.$refs.customControlsRef.querySelector('[control=collapse]');
      collapse && collapse.addEventListener('click', this.changeState.bind(this, null, 'collapse'));
      let expand = this.$refs.customControlsRef.querySelector('[control=expand]');
      expand && expand.addEventListener('click', this.changeState.bind(this, null, 'default'));
      let fullscreen = this.$refs.customControlsRef.querySelector('[control=fullscreen]');
      fullscreen && fullscreen.addEventListener('click', this.changeState.bind(this, null, 'fullscreen'));
      let restore = this.$refs.customControlsRef.querySelector('[control=restore]');
      restore && restore.addEventListener('click', this.changeState.bind(this, null, 'default'));
      let load = this.$refs.customControlsRef.querySelector('[control=load]');
      load && load.addEventListener('click', this.loadWidgster);
    }
  },
  methods: {
    closeWidget(e) {
      e && e.preventDefault();
      let $parentEl = this.$el.parentElement;
      let length = $parentEl.classList.length;
      let parentToRemove = false;
      for (let i = 0; i < length; i++) {
        if (/col.*/.test($parentEl.classList[i])) {
          parentToRemove = true;
          break;
        }
      }

      let removeFunction = () => {
        parentToRemove ? $parentEl.remove() : this.$el.remove();
      };

      if (this.$listeners && this.$listeners.close) {
        this.$listeners.close(removeFunction.bind(this));
      } else {
        removeFunction();
      }
    },
    changeState(e, state) {
      e && e.preventDefault();
      this.state = state;
    },
    loadWidgster(e) {
      e && e.preventDefault();
      this.$emit('load');
    }
  }
};
</script>

<style src="./Widget.scss" lang="scss" />
