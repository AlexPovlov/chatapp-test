<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from "@inertiajs/vue3";


const props = defineProps({
    tokens: [],
});

const form = useForm({
    app_id: null,
    email: null,
    password: null
});

function sub({ target }) {
    form.post(route("chatapp.store"));
    form.clearErrors();
    // target.reset();
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="sub">

                            <div class="form-group">
                                <label>app id</label>
                                <input v-model="form.app_id" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>емайл</label>
                                <input v-model="form.email" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>пароль</label>
                                <input v-model="form.password" class="form-control" />
                            </div>

                            <button type="submit"
                                class="mt-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Отправить
                            </button>
                        </form>

                        <div class="mt-5">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">app id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="token in props.tokens" :key="token">
                                        <td>{{ token.id }}</td>
                                        <td>{{ token.app_id }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
