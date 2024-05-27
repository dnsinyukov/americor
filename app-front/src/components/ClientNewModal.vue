<script setup>
import {onBeforeMount, onUpdated, ref} from "vue";
    import fetch from "@/services/fetch";
    import urlManager from "@/services/urlManager.js";
    import { toast } from "vue3-toastify";

    const emit = defineEmits(['close']);
    const income = ref(10000);
    const formData = ref({
        firstName: 'Denis',
        lastName: 'Sinyukov',
        email: 'dnsinyukov@gmail.com',
        ssn: null,
        fico: null,
        phone: null,
        address: null,
        age: 18,
    });

    const props = defineProps({
        show: {
            type: Boolean,
            default: false
        },
        client: {
            type: Object,
            nullable: true
        }
    });

    const close = () => emit('close');
    const loanApprove = () => {
        fetch(urlManager.route(urlManager.loan.approve), {
            method: 'POST',
            body: {
                clientId: props.client?.id,
                income: income.value
            }
        })
            .then(res => {
                toast('Loan Notification has been sent', {autoClose: 1000, type: 'success'});
            })
            .catch(e => toast('Notification Fail', {autoClose: 1000, type: 'error'}))
    }
    const loanDisbursement = () => {
        fetch(urlManager.route(urlManager.loan.validate), {
            method: 'POST',
            body: {
                clientId: props.client?.id,
                income: income.value
            }
        })
            .then(res => {
                if (res.status === false) {
                    toast('Loan Denied', {autoClose: 1000, type: 'error'});
                } else {
                    toast('Loan Approved', {autoClose: 1000, type: 'success'});
                }
            })
            .then(res => loanApprove())
            .catch(e => toast('Loan Denied', {autoClose: 1000, type: 'error'}))
    };

    const submit = () => {
        const url = urlManager.route(urlManager.clients.list);

        fetch(!props.client ? url : url + `/${props.client?.id}`, {
            method: !props.client ? 'POST' : 'PUT',
            body: formData.value
        })
            .then((res) => {
                emit('submit', Object.assign({id: res.clientId}, formData));

                toast('Congratulations!', {
                    autoClose: 1000,
                    type: "success"
                });
            })
            .catch(error => {
                toast(error.message, {
                    autoClose: 1000,
                    type: "error"
                });
            })
            .finally(() => emit('close'))
    };

    onUpdated(() => {
        if (props.client) {
            formData.value = props.client
        }
    });

    onBeforeMount(() => {
        document.onkeydown = (evt) =>  {
            evt = evt || window.event;
            let isEscape = false;
            if ("key" in evt) {
                isEscape = (evt.key === "Escape" || evt.key === "Esc");
            } else {
                isEscape = (evt.keyCode === 27);
            }
            if (isEscape) {
                emit('close');
            }
        };
    });

</script>
<template>
    <div class="modal" tabindex="-1" role="dialog" v-if="show">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ !client ? 'Create a new Client' : 'Update Client'}} <span v-if="client">: {{ client.id }}</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" class="form-control" id="firstName" placeholder="Enter First Name" v-model="formData.firstName">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" class="form-control" id="lastName" placeholder="Enter Last Name" v-model="formData.lastName">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" v-model="formData.email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" placeholder="Enter phone" v-model="formData.phone">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="Enter Address" v-model="formData.address"/>
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" class="form-control" id="age" placeholder="Enter Age" min="18" max="60" v-model="formData.age">
                    </div>
                    <div class="form-group">
                        <label for="SSN">SSN</label>
                        <input type="text" class="form-control" id="SSN" placeholder="Enter SSN" v-model="formData.ssn"/>
                    </div>
                    <div class="form-group">
                        <label for="FICO">FICO</label>
                        <input type="text" class="form-control" id="FICO" placeholder="Enter FICO" v-model="formData.fico"/>
                    </div>
                    <div class="form-group">
                        <label for="income">Income</label>
                        <input type="number" class="form-control" id="income" placeholder="Enter income" v-model="income"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                        @click.prevent="loanDisbursement"
                        v-if="client"
                    >Loan Disbursement</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click.prevent="close">Close</button>
                    <button type="button" class="btn btn-primary" @click.prevent="submit">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</template>