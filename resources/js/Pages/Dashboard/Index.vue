<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import CreateCategoryModal from '@/Components/modal/CreateCategoryModal.vue';
import EditCategoryModal from '@/Components/modal/EditCategoryModal.vue';
import DeleteCategoryModal from '@/Components/modal/DeleteCategoryModal.vue';
import DetailCategoryModal from '@/Components/modal/DetailCategoryModal.vue';


import ErrorDialog from "@/Components/ErrorDialog.vue";
import Notification from "@/Components/Notification.vue";




const createCategoryModal = ref(false)
const editCategoryModal = ref(false)
const detailCategoryModal = ref(false)
const deleteCategoryModal = ref(false)
const selectedCategory = ref(null)

defineProps({
  categories: Array,
})


function showCreateCategoryModal() {
  createCategoryModal.value = true
}


function showEditModal(category) {
  selectedCategory.value = category;
  editCategoryModal.value = true;
}

function showDetailModal(category) {
  selectedCategory.value = category;
  detailCategoryModal.value = true;
}

const showDeleteModal = (category) => {
  selectedCategory.value = category;
  deleteCategoryModal.value = true;
};


</script>

<template>

  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="mb-3 flex justify-start">
          <a href="#" @click.prevent="showCreateCategoryModal" class=" px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white
                        rounded-md
            ">Add Category</a>
        </div>

        <table class=" bg-white border border-gray-300 w-[600px]">
          <thead>
            <tr class="bg-blue-100 border-b">
              <th class="text-left py-3 px-4 font-semibold text-sm text-gray-600">Name</th>
              <th class="text-left py-3 px-4 font-semibold text-sm text-gray-600">Slug</th>
              <th class="text-left py-3 px-4 font-semibold text-sm text-gray-600">Action</th>


            </tr>
          </thead>
          <tbody>
            <tr v-for="category in categories" key="category.id" class="">
              <td class="py-3 px-4 border-b">{{ category.name }}</td>
              <td class="py-3 px-4 border-b">{{ category.slug }}</td>
              <td class="py-3 px-4 border-b space-x-3">
                <a href="#" @click.prevent="showEditModal(category)"
                  class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">Edit</a>
                <a href="#" @click.prevent="showDetailModal(category)"
                  class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Detail</a>
                <a href="#" @click.prevent="showDeleteModal(category)"
                  class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">Delete</a>
              </td>
            </tr>

            <!-- Add more rows as needed -->
          </tbody>
        </table>

        <ErrorDialog />
        <Notification />

        <CreateCategoryModal v-model="createCategoryModal" />
        <EditCategoryModal v-model="editCategoryModal" :category="selectedCategory" />
        <DeleteCategoryModal v-model="deleteCategoryModal" :category="selectedCategory" />
        <DetailCategoryModal v-model="detailCategoryModal" :category="selectedCategory" />

      </div>
    </div>

  </AuthenticatedLayout>
</template>