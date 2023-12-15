<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useForm } from "@inertiajs/vue3";
import { onMounted } from "vue";


const props = defineProps({
    mailings: [],
    tokens: []
});

onMounted(() => {
    Echo.private(`mailing-statuses`).listen("MailingStatusEvent", (e) => {
        setProgress(e.id, e.statuses);
    });
});


const setProgress = (mailingId, statuses) => {
    let mailing = props.mailings.find(el => el.id == mailingId);
    console.log(mailingId);
    statuses.forEach((element) => {
        let phone = mailing.phones.find(ele => element.phone_id == ele.id)
        if (phone)
            phone.pivot.status = element.status
    });
};

// mailing-statuses
const selectedRow = ref(0);

const addInput = () => {
    form.phones.push({ 'phone': '' });
};

const progressPhones = (phones) => {
    let total = phones.length;
    let success = phones.filter(p => p.pivot.status == 'success').length;
    let errors = phones.filter(p => p.pivot.status == 'error').length;
    if (success == 0 && errors == 0 || total == 0)
        return 0;
    return ((success + errors) / total) * 100;
};

const form = useForm({
    message: null,
    token_id: null,
    phones: [{ 'phone': '' }]
});

function sub({ target }) {
    form.post(route("mailing.store"));
    form.clearErrors();
    target.reset();
}

const toggleRow = (index) => {
    if (selectedRow.value === index)
        selectedRow.value = null;
    else
        selectedRow.value = index;
};

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Рассылка вацап</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="sub">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Сообщение</label>
                                <textarea class="form-control" v-model="form.message" id="exampleFormControlTextarea1"
                                    rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Токен</label>
                                <select v-model="form.token_id" class="form-control" id="exampleFormControlSelect1">
                                    <option v-for="token in tokens" :value="token.id">{{ token.app_id }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Номера</label>
                                <template v-for="(input, index) in form.phones" :key="index">
                                    <input v-model="form.phones[index]['phone']" class="form-control mb-3" />
                                </template>
                            </div>

                            <button @click.prevent="addInput"
                                class="mt-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Добавить номер
                            </button>

                            <button type="submit"
                                class="ml-3 mt-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Отправить
                            </button>
                        </form>

                        <div class="mt-5">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Текст</th>
                                        <th scope="col">Дата</th>
                                        <th scope="col">Прогресс</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="mailing, i in props.mailings" :key="i">
                                        <tr @click="toggleRow(i)">
                                            <th scope="row">{{ mailing.id }}</th>
                                            <td>{{ mailing.message }}</td>
                                            <td>{{ mailing.created_at }}</td>
                                            <td>
                                                <div v-if="progressPhones(mailing.phones) != 100" class="progress">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                        role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                                        aria-valuemax="100" :style="{
                                                            width: progressPhones(mailing.phones) + '%',
                                                        }"></div>
                                                </div>
                                                <div v-else>
                                                    success
                                                </div>
                                            </td>
                                        </tr>
                                        <template v-if="selectedRow == i">
                                            <tr>
                                                <table class="table">
                                                    <thead>
                                                        <tr class="info">
                                                            <th>Номер</th>
                                                            <th>Статус</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <tr v-for="phone in props.mailings[selectedRow].phones">
                                                            <td>{{ phone.phone }}</td>
                                                            <td>{{ phone.pivot.status }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </tr>
                                        </template>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
