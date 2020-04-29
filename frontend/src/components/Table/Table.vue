<template lang="pug">
  .table-container
    slot.table-title.mb-4(name="header")
    .table-search.mb-3(v-if="search")
      input.form-control(type="text" v-model="searchText" placeholder="Поиск")
    .table-columns(
      :class="{'bordered-table-header': isBorderedTable}"
    )
      .table-column(
        v-for="column in columns"
        :class="{[`width${column.width||'-auto'}`]: true}"
      )
        .table-column-title
          div(v-if="!hasSlot('column')")
            div(v-if="sort" @click="changeSorting(column.name)")
              | {{ column.title || column.name}}
              i.glyphicon.glyphicon-sort
            div(v-else) {{ column.title || column.name}}
          slot(v-else name="column" :value="column.name")
    .table-content(
      :class="{'bordered-table-body': isBorderedTable}"
      v-if="getValues.length > 0"
    )
      .table-content-row(
        v-for="value in getValues"
        :class="{'stripped-table': isStrippedTable, 'hover-table': isHoverTable}"
      )
        slot(name="table_beforeRow", :value="value")
        .row-content(
          v-for="column in columns"
          :class="{[`width${column.width||'-auto'}`]: true, 'bordered-table-cell': isBorderedTable}"
        )
          div
            div(v-if="!hasSlot(column.name)") {{ value[column.name] }}
            slot(v-else :name="column.name" :value="value")
        slot(name="table_afterRow", :value="value")
    .table-content(v-else)
      .table-content-row
        .row-content {{ 'Данные...' }}
    .table_pagination.mt-5(v-if="pagination")
      paginate(
        v-if="pageCount > 1"
        :page-count="pageCount"
        :page-range="3"
        :margin-pages="2"
        :click-handler="paginationClick "
        :container-class="'pagination'"
        page-link-class="page-link"
        next-link-class="page-link"
        prev-link-class="page-link"
        prev-text="<"
        next-text=">"
        :page-class="'page-item'"
        :next-class="'page-item'"
        :prev-class="'page-item'"
      )
</template>

<script>
	export default {
		name: "TableComponent",
		props: {
			columns: {
				type: Array,
				default() {
					return []
				},
			},
			values: {
				type: Array,
				default() {
					return []
				},
			},
			pagination: {
				type: Boolean,
				default: false,
			},
			search: {
				type: Boolean,
				default: false,
			},
			searchField: {
				type: String,
				default: 'name',
			},
			sort: {
				type: Boolean,
				default: false,
			},
			type: {
				type: String,
				default: '',
			},
			pageCount: {
				type: Number,
			},
		},
		data() {
			return {
				sorting: {
					field: '',
					type: 'ASC',
				},
				searchText: '',
				records: this.values,
			}
		},
		computed: {
			getValues() {
				if (this.searchText === '' && this.sorting.field === '') {
					return this.values;
				}
				if (this.sorting.field !== '' && this.searchText === '') {
					// eslint-disable-next-line vue/no-side-effects-in-computed-properties
					return this.values.sort((a, b) => {
						let modifier = (this.sorting.type === 'DESC') ? -1 : 1;
						const bandA = a[this.sorting.field].toLowerCase();
						const bandB = b[this.sorting.field].toLowerCase();
						if (bandA < bandB) {
							return -1 * modifier;
						}
						if (bandA > bandB) {
							return 1 * modifier;
						}
						return 0;
					});
				}
				return this.values.filter((item) => {
					return item[this.searchField].toLowerCase().indexOf(this.searchText.toLowerCase()) !== -1;
				})
			},
			isStrippedTable() {
				return this.type === 'stripped';
			},
			isHoverTable() {
				return this.type === 'hover';
			},
			isBorderedTable() {
				return this.type === 'bordered';
			},
		},
		methods: {
			hasSlot(name) {
				return this.$slots[name] || this.$scopedSlots[name];
			},
			changeSorting(columnName) {
				if (this.sorting.field === columnName) {
					this.$set(this.sorting, 'type', this.sorting.type === 'ASC' ? 'DESC' : 'ASC');
					return;
				}
				this.$set(this.sorting, 'type', 'ASC');
				this.$set(this.sorting, 'field', columnName);
			},
			paginationClick(pageNum) {
				this.$emit('page-change', pageNum);
			},
		},
	}
</script>

<style scoped>
	.table-columns, .table-content-row {
		display: flex;
		justify-content: flex-start;
	}

	.row-content, .table-column {
		padding: 10px;
		display: flex;
		align-items: center;
		border-bottom: 1px solid #D7DFE6;
		flex: 1;
	}

	.table-container {
		overflow: auto;
	}

	.table-column-title {
		flex-grow: 1;
	}

	.bordered-table-header {
		background: #005792;
		color: #ffffff;
	}

	.bordered-table-body {
		border-right: 1px solid #D7DFE6;
	}

	.bordered-table-cell {
		border-left: 1px solid #D7DFE6;
		min-height: 100%;
		margin: 0;
	}

	.hover-table:hover {
		background: #ECECEC;
	}

	.table-columns {
		font-weight: bold;
	}

	.stripped-table:nth-child(odd) .row-content {
		background-color: #F8F9FA;
	}

	.width5 {
		flex: 0 0 5%;
		max-width: 5%;
	}


	.width7 {
		flex: 0 0 7%;
		max-width: 7%;
	}


	.width8 {
		flex: 0 0 8%;
		max-width: 8%;
	}


	.width10 {
		flex: 0 0 10%;
		max-width: 10%;
	}


	.width11 {
		flex: 0 0 11%;
		max-width: 11%;
	}


	.width12 {
		flex: 0 0 12%;
		max-width: 12%;
	}


	.width13 {
		flex: 0 0 13%;
		max-width: 13%;
	}


	.width14 {
		flex: 0 0 14%;
		max-width: 14%;
	}


	.width15 {
		flex: 0 0 15%;
		max-width: 15%;
	}

	.width16 {
		flex: 0 0 16%;
		max-width: 16%;
	}


	.width18 {
		flex: 0 0 18%;
		max-width: 18%;
	}


	.width19 {
		flex: 0 0 19%;
		max-width: 19%;
	}


	.width20 {
		flex: 0 0 20%;
		max-width: 20%;
	}

	.width21 {
		flex: 0 0 21%;
		max-width: 21%;
	}


	.width22 {
		flex: 0 0 22%;
		max-width: 22%;
	}

	.width25 {
		flex: 0 0 25%;
		max-width: 25%;
	}

	.width30 {
		flex: 0 0 30%;
		max-width: 30%;
	}

	.width35 {
		flex: 0 0 35%;
		max-width: 35%;
	}

	.width40 {
		flex: 0 0 40%;
		max-width: 40%;
	}

	.width45 {
		flex: 0 0 45%;
		max-width: 45%;
	}

	.width50 {
		flex: 0 0 50%;
		max-width: 50%;
	}

	.width55 {
		flex: 0 0 55%;
		max-width: 55%;
	}


	.width60 {
		flex: 0 0 60%;
		max-width: 60%;
	}

	.width65 {
		flex: 0 0 65%;
		max-width: 65%;
	}

	.width70 {
		flex: 0 0 70%;
		max-width: 70%;
	}

	.width75 {
		flex: 0 0 75%;
		max-width: 75%;
	}

	.width80 {
		flex: 0 0 80%;
		max-width: 80%;
	}

	.width85 {
		flex: 0 0 85%;
		max-width: 85%;
	}

	.width90 {
		flex: 0 0 90%;
		max-width: 90%;
	}

	.width95 {
		flex: 0 0 95%;
		max-width: 95%;
	}
</style>
