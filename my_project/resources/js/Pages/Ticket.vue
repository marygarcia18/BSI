<script setup>
    defineProps({
        title : String
    })
</script>

<template>
    <div class="container mt-5">
      <h3 class="text-center">Tickets</h3>
      <div class="text-end mb-3">
        <inertia-link href="/tickets/create" class="btn btn-primary">Create New Ticket</inertia-link>
      </div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Title {{ title }}</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="ticket in tickets" :key="ticket.id">
            <td>{{ ticket.title }}</td>
            <td>{{ ticket.status }}</td>
            <td>
              <inertia-link :href="`/tickets/${ticket.id}/edit`" class="btn btn-warning btn-sm">Edit</inertia-link>
              <button @click="deleteTicket(ticket.id)" class="btn btn-danger btn-sm">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
</template>
  
  <!-- <script>
  export default {
    props: {
      tickets: Array,
    },
    methods: {
      async deleteTicket(id) {
        if (confirm('Are you sure you want to delete this ticket?')) {
          this.$inertia.delete(`/tickets/${id}`);
        }
      },
    },
  };
  </script> -->

  