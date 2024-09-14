<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, useForm } from '@inertiajs/vue3';


const props = defineProps({
  post: Object,
  comments: Object
});
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

const form = useForm({
  body: "",
  post_id: props.post.id



})



</script>

<template>

  <Head title="Detail Post" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Post</h2>
    </template>


    <div class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="mx-auto shadow-lg rounded-md">
          <div class="bg-blue-100 p-2">
            <h5 class="text-2xl font-semibold">{{ post.title }}</h5>

          </div>

          <div v-if="post.image == null">
            <img src="../../Components/image/no-image.jpg" alt="No image available" class="" />
          </div>
          <div v-else>
            <img :src="post.image_url" class="w-full" alt="">

          </div>
          <div class="p-2 bg-blue-100">

            <Link :href="`/categories/${post.category.slug}`">
            <div class="text-blue-700 text-sm">#{{ post.category.name }}</div>
            </Link>
            <div class="flex items-baseline space-x-2 ">
              <div class="font-semibold">@{{ post.user.name }}</div>
              <div class="text-slate-500 text-sm">{{ post.create_format }}</div>
            </div>
            <div class="my-2" v-html="post.body"></div>

            <div class="flex justify-end mr-3">

              <Link :href="`/posts`" class="px-2 py-1 text-sm bg-gray-700 rounded-md hover:bg-gray-600 text-white">
              Back
              </Link>


            </div>


          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
