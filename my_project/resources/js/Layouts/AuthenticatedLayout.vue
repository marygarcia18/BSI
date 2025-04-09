<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div>
        <!-- Header -->
        <header class="bg-light py-3 border-bottom mb-4">
            <div class="container d-flex justify-content-between align-items-center">
                <div>
                    <slot name="header" />
                </div>
                <div>
                    <!-- user dropdown -->
                    <div class="dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="userDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            {{ $page.props.auth.user.name }} <!--dito lalabas yung name ng user-->
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <Link class="dropdown-item" :href="route('profile.edit')">Profile</Link>
                            </li>
                            <li>
                                <Link
                                    class="dropdown-item"
                                    method="post"
                                    as="button"
                                    :href="route('logout')"
                                >
                                    Log Out
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <main class="container mb-5">
            <slot />
        </main>
    </div>
</template>
