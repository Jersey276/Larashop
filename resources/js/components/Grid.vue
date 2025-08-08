<template>
  <div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <div v-for="item in items.data" :key="item.id" class="border p-4">
        <img :src="item.image_path" alt="Item Image" class="w-full h-48 object-cover">
        <h2 class="text-xl font-bold">{{ item.title }}</h2>
        <p>{{ item.description }}</p>
      </div>
    </div>
    <div class="mt-4">
      <button
        @click="fetchItems(pagination.current_page - 1)"
        :disabled="pagination.current_page === 1"
        class="px-4 py-2 bg-blue-500 text-white rounded"
      >
        Previous
      </button>
      <span class="mx-4">Page {{ pagination.current_page }} of {{ pagination.last_page }}</span>
      <button
        @click="fetchItems(pagination.current_page + 1)"
        :disabled="pagination.current_page === pagination.last_page"
        class="px-4 py-2 bg-blue-500 text-white rounded"
      >
        Next
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    items: {
      type: Object,
      required: true
    },
    fetchUrl: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      pagination: this.items
    };
  },
  methods: {
    fetchItems(page = 1) {
      this.$inertia.get(`${this.fetchUrl}?page=${page}`, {}, {
        preserveState: true,
        replace: true
      });
    }
  }
};
</script>
