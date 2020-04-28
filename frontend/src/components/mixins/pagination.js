import {mapGetters} from 'vuex';

export default {
  computed: {
    ...mapGetters('client', [
      'pagination',
    ]),
  },
  methods: {
    calculatePageCount(perPage){
      let pagination = this.pagination;
      if (pagination && pagination.total) {
        return Math.ceil(pagination.total / perPage)
      }
      return 1;
    },
  }
}
