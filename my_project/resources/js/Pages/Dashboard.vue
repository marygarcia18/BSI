<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, defineProps, computed } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { Link } from '@inertiajs/vue3';
import 'bootstrap';
import axios from 'axios';

import View from '@/Pages/Tickets/View.vue';

const isModalVisible = ref(false);
const selectedTicket = ref(null);

const viewTicket = (ticket) => {
    selectedTicket.value = ticket;
    isModalVisible.value = true;
};

const closeModal = () => {
    isModalVisible.value = false;
    selectedTicket.value = null;
};

import CreateModal from '@/Pages/Tickets/CreateModal.vue';
const isCreateModalVisible = ref(false);
const showCreateModal = () => isCreateModalVisible.value = true;
const closeCreateModal = () => isCreateModalVisible.value = false;


// this const shows how to get data from the backend (server) papunta sa component.
const props = defineProps({
    isAdmin: Boolean,
    tickets: Array,
    userTickets: Array,
    canCreate: Boolean,
    debug: Boolean
});

const page = usePage();
// const user = page.props.user;
const tickets = ref(props.tickets);
const userTickets = ref(props.userTickets);

const filters = ref({
    category: '',
    status: ''
});

const filteredTickets = computed(() => {
    return tickets.value.filter(ticket => {
        const matchesCategory = !filters.value.category || ticket.category === filters.value.category;
        const matchesStatus = !filters.value.status || ticket.status.toLowerCase() === filters.value.status.toLowerCase();
        return matchesCategory && matchesStatus;
    });
});

const createTicket = () => {
    router.get('/tickets/create');
};

// const deleteTicket = (ticketId) => {
//     if (confirm('Are you sure you want to delete this ticket?')) {
//         router.delete(`/tickets/${ticketId}`);
//         router.visit('/dashboard');
//     }
// };

const deleteTicket = (ticket) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "This ticket will be marked as deleted.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Send a request to the server to set the `admin_delete` flag to 1
            router.patch(`/tickets/${ticket.id}/delete`).then(response => {
                // After marking as deleted, we can reload the page or navigate to the dashboard
                router.visit('/dashboard');
            }).catch(error => {
                console.error("Error deleting ticket:", error);
            });
        }
    });
};


const permanentlyDeleteTicket = (ticket) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "This ticket will be permanently deleted.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/ticket/permanently/${ticket.id}`)
                .then(() => {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'The ticket has been permanently deleted.',
                        icon: 'success',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        router.visit('/dashboard'); 
                    });
                })
                .catch((error) => {
                    console.error('Error deleting ticket:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an issue deleting the ticket.',
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    });
                });
        }
    });
};

// const permanentlyDeleteTicket = (ticket) => {
//     if (confirm("Are you sure you want to permanently delete this ticket?")) {
//         axios.delete(`/ticket/permanently/${ticket.id}`).then(response => {
//             window.location.href = '/dashboard';
//         }).catch(error => {
//             console.error("Error deleting ticket:", error);
//         });
//     }
// };

const updatePriority = async (ticket) => {
    try {
        await router.patch(`/tickets/${ticket.id}`, {
            priority: ticket.priority
        }, {
            preserveScroll: true,
            onError: () => {
                ticket.priority = ticket._originalPriority;
            },
            onSuccess: () => {
                ticket._originalPriority = ticket.priority;
            }
        });
    } catch (error) {
        console.error('Error updating priority:', error);
        ticket.priority = ticket._originalPriority;
    }
};

const updateStatus = async (ticket) => {
    try {
        await router.patch(`/tickets/${ticket.id}`, {
            status: ticket.status
        }, {
            preserveScroll: true,
            onError: () => {
                ticket.status = ticket._originalStatus;
            },
            onSuccess: () => {
                ticket._originalStatus = ticket.status;
            }
        });
    } catch (error) {
        console.error('Error updating status:', error);
        ticket.status = ticket._originalStatus;
    }
};

onMounted(() => {
    console.log('Tickets data:', props.tickets);
    if (props.tickets && props.tickets.length > 0) {
        console.log('First ticket data:', JSON.stringify(props.tickets[0], null, 2));
    }
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h4 fw-semibold text-dark">
                    {{ isAdmin ? 'Admin Dashboard' : 'User Dashboard' }}
                </h2>
            </div>
        </template>

        <div class="py-4">
            <div class="container">
                <!-- Flash Message -->
                <div v-if="$page.props.flash && $page.props.flash.message" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $page.props.flash.message }}
                    <button type="button" class="btn-close" @click="$page.props.flash.message = null"></button>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <!-- Admin Dashboard -->
                        <div v-if="isAdmin">
                            <div class="row mb-3">
                                <div class="col-md">
                                    <h3 class="h5">All Tickets</h3>
                                </div>
                                <div class="col-md d-flex gap-2">
                                    <select v-model="filters.category" class="form-select">
                                        <option value="">All Categories</option>
                                        <option value="tech_issues">Tech Issues</option>
                                        <option value="billing_concerns">Billing Concerns</option>
                                        <option value="general_inquiry">General Inquiry</option>
                                    </select>
                                    <select v-model="filters.status" class="form-select">
                                        <option value="">All Statuses</option>
                                        <option value="Open">Open</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Resolved">Resolved</option>
                                    </select>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>User</th>
                                            <th>Status</th>
                                            <th>Priority</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="ticket in filteredTickets" :key="ticket.id">
                                            <td>{{ ticket.title }}</td>
                                            <td><span class="badge bg-secondary">{{ ticket.category.replace('_', ' ') }}</span></td>
                                            <td>{{ ticket.user.name }}</td>
                                            <td class="px-3 py-2">
                                                <select
                                                    v-model="ticket.status"
                                                    @change="updateStatus(ticket)"
                                                    class="form-select text-center fw-semibold border-0 shadow-sm"
                                                    :class="{
                                                        'bg-info text-white': ticket.status === 'Open',
                                                        'bg-warning text-white': ticket.status === 'In Progress',
                                                        'bg-success text-white': ticket.status === 'Resolved',
                                                    }"
                                                    style="width: auto; min-width: 120px; text-align: center; text-align-last: center;"
                                                >
                                                    <option value="Open" class="bg-white text-dark">Open</option>
                                                    <option value="In Progress" class="bg-white text-dark">In Progress</option>
                                                    <option value="Resolved" class="bg-white text-dark">Resolved</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select v-model="ticket.priority" @change="updatePriority(ticket)" class="form-select">
                                                    <option value="low">Low</option>
                                                    <option value="medium">Medium</option>
                                                    <option value="high">High</option>
                                                </select>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2 justify-content-end">
                                                    <button @click="viewTicket(ticket)" class="btn btn-sm btn-outline-primary">View</button>
                                                    <button @click="deleteTicket(ticket)" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-if="filteredTickets.length === 0">
                                            <td colspan="6" class="text-center text-muted">No tickets found</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- User Dashboard -->
                        <div v-else>
                            <h2 class="h5 mb-3">My Tickets</h2>
                            <button @click="showCreateModal" class="btn btn-primary mb-4">
                                <i class="bi bi-plus-circle me-1"></i>
                                Create Ticket
                            </button>

                            <div v-if="userTickets.length > 0" class="row g-3">
                                <div 
                                    v-for="ticket in userTickets" 
                                    :key="ticket.id"
                                    class="col-12"
                                >
                                    <!--yung color-border here ang indicator ng priority-->
                                    <div 
                                        class="card border-start border-4"
                                        :class="{
                                            'border-danger': ticket.priority === 'high',
                                            'border-warning': ticket.priority === 'medium',
                                            'border-primary': ticket.priority === 'low'
                                        }"
                                    >
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5 class="card-title fw-semibold">Concern: {{ ticket.title }}</h5>
                                                <p class="card-text text-dark fs-5.5">{{ ticket.description }}</p>
                                            </div>
                                            <span
                                                class="badge d-inline-flex align-items-center text-white"
                                                style="padding: 0.25rem 0.5rem; font-size: 0.875rem; border-radius: 0.25rem; height: calc(1.5em + 0.5rem + 2px);"
                                                :class="{
                                                    'bg-info': ticket.status === 'Open',
                                                    'bg-warning': ticket.status === 'In Progress',
                                                    'bg-success': ticket.status === 'Resolved'
                                                }"
                                            >
                                                {{ ticket.status }}
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <small class="d-flex align-items-center gap-2 text-muted fs-8 mb-0">
                                                Created at: {{ new Date(ticket.created_at).toLocaleString() }}
                                            </small>
                                            <button @click="permanentlyDeleteTicket(ticket)" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash-fill me-1"></i> Delete
                                            </button>
                                        </div>

                                    </div>

                                    </div>
                                </div>
                            </div>

                            <div v-else class="alert alert-secondary text-center">
                                You don't have any tickets yet.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <View
            v-if="isModalVisible"
            :ticket="selectedTicket"
            @close="closeModal"
        />

        <CreateModal v-if="isCreateModalVisible" @close="closeCreateModal" />

    </AuthenticatedLayout>
</template>

<style>
    select.form-select option {
        background-color: white !important;
        color: #212529 !important;
        text-align: left;
    }

</style>