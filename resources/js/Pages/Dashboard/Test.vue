<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';




const form = useForm({})
const submit = () => {
  form.post(route("test.store"), {
    onSuccess: () => {
      // Perform any additional actions after success
    },
    onFinish: () => {
      form.reset();
    }
  });
};



</script>

<template>

  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">test</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">



        <form @submit.prevent="submit">
          <button type="submit">submit</button>
        </form>




      </div>
    </div>

  </AuthenticatedLayout>
</template>