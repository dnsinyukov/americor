<script setup>
import urlManager from "@/services/urlManager.js";
import {onBeforeMount, ref} from "vue";
// import {ofetch} from "ofetch";
import fetch from "@/services/fetch.js";
import ClientNewModal from "@/components/ClientNewModal.vue";

const clients = ref([]);
const showNewClient = ref(false);
const clientValue = ref(null);

const toggleClientModal = () => {
    clientValue.value = null;
    showNewClient.value = !showNewClient.value;
}

const onSubmit = (payload) => {
    clients.value.push(payload);
}

const updateClient = (client) => {
    showNewClient.value = true;
    clientValue.value = client;
}

onBeforeMount(() => {
    fetch(urlManager.route(urlManager.clients.list))
        .then((res) => clients.value = res.clients);
});

</script>

<template>
    <div class="col-md-8 order-md-1">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <p class="navbar-text">Clients</p>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <button class="btn btn-default navbar-btn" @click="toggleClientModal">Create Client</button>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="panel panel-default">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>FICO</th>
                    <th>Address</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="client in clients">
                    <th scope="row">{{ client.id }}</th>
                    <td>{{ client.firstName }}</td>
                    <td>{{ client.lastName }}</td>
                    <td>{{ client.email }}</td>
                    <td>{{ client.fico }}</td>
                    <td>{{ client.address }}</td>
                    <td role="button" @click="updateClient(client)">
                        <svg fill="#000000" version="1.1"xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink"
                             width="24px" height="24px" viewBox="0 0 528.899 528.899"
                             xml:space="preserve"
                        >
                            <g>
                                <path d="M328.883,89.125l107.59,107.589l-272.34,272.34L56.604,361.465L328.883,89.125z M518.113,63.177l-47.981-47.981
                                    c-18.543-18.543-48.653-18.543-67.259,0l-45.961,45.961l107.59,107.59l53.611-53.611
                                    C532.495,100.753,532.495,77.559,518.113,63.177z M0.3,512.69c-1.958,8.812,5.998,16.708,14.811,14.565l119.891-29.069
                                    L27.473,390.597L0.3,512.69z"/>
                            </g>
                        </svg>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <ClientNewModal
            :show="showNewClient"
            :client="clientValue"
            @close="showNewClient = false"
            @submit="onSubmit"
        />
    </div>
</template>

