<script setup>
defineProps({ tickets: Array });
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <div>
    <h1 class="text-xl font-bold mb-4">All Tickets</h1>
    <Link href="/tickets/create" class="btn btn-primary mb-4">Create Ticket</Link>

    <table class="table-auto w-full">
      <thead>
        <tr>
          <th>Subject</th>
          <th>Status</th>
          <th>Category</th>
          <th>Priority</th>
          <th>User</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="ticket in tickets" :key="ticket.id">
          <td>{{ ticket.subject }}</td>
          <td>{{ ticket.status }}</td>
          <td>{{ ticket.category }}</td>
          <td>{{ ticket.priority }}</td>
          <td>{{ ticket.user.name }}</td>
          <td>
            <Link :href="`/tickets/${ticket.id}/edit`" class="text-blue-600">Edit</Link>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>


