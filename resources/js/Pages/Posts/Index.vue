<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import noImage from '../../Components/image/no-image.jpg'
import { Inertia } from "@inertiajs/inertia"
import { ref } from 'vue'
import DeleteModal from '@/Components/modal/DeleteModal.vue'


const deletePostModal = ref(false);
const selectedPost = ref(null)

const showDeleteModal = (post) => {
  selectedPost.value = post;
  deletePostModal.value = true;
};


defineProps({
  posts: Object,

})

const deletePost = (id) => {
  if (confirm('Are you sure you want to delete this post?')) {
    Inertia.delete(route('posts.destroy', id), {
      onSuccess: () => {
        // Logika setelah berhasil menghapus post
        console.log('Post has been deleted!');
      }
    });
  }
};


</script>

<template>

  <Head title="Post" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Posts</h2>
    </template>


    <div class="py-6">
      <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-3 flex justify-end">
          <Link href="/posts/create" class=" px-2 py-1 bg-indigo-500 hover:bg-indigo-700 text-white text-sm
                        rounded-md
            ">New Post</Link>
        </div>

        <table class=" bg-white border border-gray-300 w-full">
          <thead>
            <tr class="bg-blue-100 border-b">
              <th class="text-left py-3 px-4 font-semibold text-sm text-gray-600">Title</th>
              <th class="text-left py-3 px-4 font-semibold text-sm text-gray-600">
                Slug
              </th>
              <th class="text-left py-3 px-4 font-semibold text-sm text-gray-600">Image</th>
              <th class="text-left py-3 px-4 font-semibold text-sm text-gray-600">Action</th>

            </tr>
          </thead>
          <tbody>
            <tr v-for="post in posts.data" key="post.id" class="hover:bg-gray-50">
              <td class="py-3 px-4 border-b">{{ post.title }}</td>
              <td class="py-3 px-4 border-b">{{ post.slug }}</td>
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



      </div>
    </div>

    <DeleteModal v-model="deletePostModal" :post="selectedPost" />

  </AuthenticatedLayout>
</template>