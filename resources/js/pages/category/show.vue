<template>
  <div>
    <input v-model="search" @input="fetchData" placeholder="Rechercher..." />
    <table>
      <thead>
        <tr>
          <th v-for="column in columns" :key="column.field" @click="sortBy(column.field)">
            {{ column.label }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in data" :key="item.id">
          <td v-for="column in columns" :key="column.field">
            <template v-if="column.children">
              <table>
                <tr v-for="(child, index) in getChildren(item, column.field)" :key="index">
                  <td v-for="childColumn in column.children" :key="childColumn.field">
                    {{ child[childColumn.field] }}
                  </td>
                </tr>
              </table>
            </template>
            <template v-else>
              {{ item[column.field] }}
            </template>
          </td>
        </tr>
      </tbody>
    </table>
    <div>
      <button @click="prevPage" :disabled="currentPage === 1">Précédent</button>
      <span>Page {{ currentPage }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages">Suivant</button>
    </div>
  </div>
</template>

<script lang="ts">
export default {
  props: {
    columns: {
      type: Array,
      required: true,
    },
    apiUrl: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      data: [],
      search: '',
      currentPage: 1,
      totalPages: 1,
      sort: '',
    };
  },
  methods: {
    async fetchData() {
      const response = await fetch(
        `${this.apiUrl}?page=${this.currentPage}&search=${this.search}&sort=${this.sort}`
      );
      const result = await response.json();
      this.data = result.data;
      this.totalPages = result.last_page;
    },
    sortBy(field) {
      if (this.sort === field) {
        this.sort = `-${field}`;
      } else {
        this.sort = field;
      }
      this.fetchData();
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
        this.fetchData();
      }
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.fetchData();
      }
    },
    getChildren(item, field) {
      return item[field] || [];
    },
  },
  mounted() {
    this.fetchData();
  },
};
</script>