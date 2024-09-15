<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import noImage from '../../Components/image/no-image.jpg'
import { Inertia } from "@inertiajs/inertia"
import { ref, watch } from 'vue'
import DeleteModal from '@/Components/modal/DeleteModal.vue'
import Pagination from '@/Components/Pagination.vue'
import { debounce } from 'lodash';


const deletePostModal = ref(false);
const selectedPost = ref(null)

const showDeleteModal = (post) => {
  selectedPost.value = post;
  deletePostModal.value = true;
};


const props = defineProps({
  posts: Object,
  filters: Object,

})

const search = ref(props.filters.search)

const debouncedSearch = debounce((value) => {
  Inertia.get('/posts', { search: value }, {
    preserveState: true,
    replace: true,
  });
}, 300);

watch(search, value => {
  debouncedSearch(value);
});




</script>

<template>

  <Head title="Post" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Posts</h2>
    </template>


    <div class="py-6">
      <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="relative mb-5">
          <input type="text" v-model="search"
            class="py-2 pl-10 pr-3 w-64 border border-gray-300 rounded-lg outline-none focus:border-blue-500">
          <button type="submit" class="absolute left-2 top-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
          </button>
          <!-- Clear button -->
          <button v-if="search" @click="search = ''" class="absolute left-56 top-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-6 font-semibold p-1 rounded-full bg-blue-300">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="mb-3 flex justify-end">
          <Link href="/posts/create" class=" px-2 py-1 bg-indigo-500 hover:bg-indigo-700 text-white text-sm
                        rounded-md
            ">New Post</Link>
        </div>

        <table class=" bg-white border border-gray-300 w-full">
          <thead>
            <tr class="bg-blue-100 border-b">
              <th class="text-left py-3 px-4 font-semibold text-sm text-gray-600">Title</th>
              <th class="text-left py-3 px-4 font-semibold text-sm text-gray-600">Slug</th>
              <th class="text-left py-3 px-4 font-semibold text-sm text-gray-600">Category</th>
              <th class="text-left py-3 px-4 font-semibold text-sm text-gray-600">Image</th>
              <th class="text-left py-3 px-4 font-semibold text-sm text-gray-600">Action</th>

            </tr>
          </thead>
          <tbody>
            <tr v-for="post in posts.data" key="post.id" class="">
              <td class="py-3 px-4 border-b">{{ post.title }}</td>
              <td class="py-3 px-4 border-b">{{ post.slug }}</td>
              <td class="py-3 px-4 border-b">
                <Link :href="`/categories/${post.category.slug}`" class="hover:text-blue-700">
                {{ post.category.name }}
                </Link>
              </td>
              <td v-if="post.image == null" class="py-3 px-4 border-b">
                <img :src="noImage" alt="No image available" class="w-8 h-8" />
              </td>
              <td v-else class="py-3 px-4 border-b">
                <img :src="post.image_url + '/' + post.image" class="w-8 h-8 rounded-full" />
              </td>


              <td class="py-3 px-4 border-b space-x-3">
                <Link :href="`/posts/${post.slug}/edit`"
                  class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                Edit</Link>
                <Link :href="`/posts/${post.slug}`"
                  class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                Show</Link>
                <button @click.prevent="showDeleteModal(post)"
                  class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">Delete</button>
              </td>
            </tr>

            <!-- Add more rows as needed -->
          </tbody>
        </table>
        <div v-if="!posts.data.length" class="py-8 text-center text-sm text-gray-400">
          There is no record data.
        </div>

        <Pagination :links="posts.meta.links" />



      </div>
    </div>

    <DeleteModal v-model="deletePostModal" :post="selectedPost" />

  </AuthenticatedLayout>
</template>