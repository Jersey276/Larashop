<template>
  <div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
      <div class="mb-4">
        <input
          v-model="search"
          @input="fetchData"
          placeholder="Rechercher..."
          class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
          <thead>
            <tr>
              <th
                v-for="column in columns"
                :key="column.field"
                @click="sortBy(column.field)"
                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
              >
                {{ column.label }}
              </th>
              <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in data" :key="item.id" class="hover:bg-gray-50">
              <td
                v-for="column in columns"
                :key="column.field"
                class="px-6 py-4 whitespace-no-wrap border-b border-gray-200"
              >
                <template v-if="column.children">
                  <table class="min-w-full">
                    <tr v-for="(child, index) in getChildren(item, column.field)" :key="index">
                      <td
                        v-for="childColumn in column.children"
                        :key="childColumn.field"
                        class="px-6 py-4 whitespace-no-wrap border-b border-gray-200"
                      >
                        {{ child[childColumn.field] }}
                      </td>
                    </tr>
                  </table>
                </template>
                <template v-else>
                  {{ item[column.field] }}
                </template>
              </td>
              <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                <div class="flex space-x-2">
                  <button
                    v-for="(button, index) in actionButtons"
                    :key="index"
                    @click="button.action(item)"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                  >
                    {{ button.label }}
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="flex items-center justify-between mt-4">
        <button
          @click="prevPage"
          :disabled="currentPage === 1"
          class="px-4 py-2 text-sm font-medium text-white bg-gray-500 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 disabled:opacity-50"
        >
          Précédent
        </button>
        <span class="text-sm font-medium text-gray-700">Page {{ currentPage }}</span>
        <button
          @click="nextPage"
          :disabled="currentPage === totalPages"
          class="px-4 py-2 text-sm font-medium text-white bg-gray-500 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 disabled:opacity-50"
        >
          Suivant
        </button>
      </div>
    </div>
  </div>
</template>

<script>
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
    actionButtons: {
      type: Array,
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
      const url = new URL(this.apiUrl);
      url.searchParams.append('page', this.currentPage);
      if (this.search) {
        url.searchParams.append('search', this.search);
      }
      if (this.sort) {
        url.searchParams.append('sort', this.sort);
      }

      const response = await fetch(url.toString());
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
