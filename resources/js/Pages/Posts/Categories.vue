<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';


defineProps({
  posts: Object,
  image_url: String,
  category: String
})


</script>

<template>

  <Head title="Posts by Category" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ category }}</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex justify-start gap-3">
          <!-- <pre>{{ posts }}</pre> -->
          <div v-for="post in posts" key="post.id">
            <div class="border-2 border-gray-400">
              <Link :href="`/posts/${post.slug}`" class="text-2xl mb-3">
              <div v-if="post.image == null">
                <img src="../../Components/image/no-image.jpg" alt="No image available" class="w-60 h-52" />
              </div>
              <div v-else>
                <img :src="image_url + '/' + post.image" class="w-60 h-52" />

              </div>
              <div class="text-sm p-3 mt-2">{{ category }}</div>


              <div class="px-3">
                {{ post.title }}

              </div>

              </Link>

            </div>

          </div>

        </div>
      </div>
    </div>


  </AuthenticatedLayout>
</template>
