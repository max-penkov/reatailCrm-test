<template lang="pug">
  footer(:class="active_class")
    | {{ $t('common.footer') }}
</template>
<script>
  export default {
    name: 'Footer',
    props: {
      active_class: {
        type: String,
        default: 'contentFooter'
      }
    }
  }
</script>
