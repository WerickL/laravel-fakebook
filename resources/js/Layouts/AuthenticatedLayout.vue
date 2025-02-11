<script>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
export default {
    name: 'AuthenticatedLayout',
    components: {
        ApplicationLogo,Dropdown,DropdownLink,NavLink,ResponsiveNavLink,Link
    },
    data:function () {
        return {
            showingNavigationDropdown:   ref(false)
        }
    } 
};
</script>

<template>
    <div>
        <div class="tw-min-h-screen tw-bg-gray-100">
            <nav class="tw-bg-white tw-border-b tw-border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="tw-max-w-7xl tw-mx-auto tw-px-4 sm:tw-px-6 tw-lg:tw-px-8">
                    <div class="tw-flex tw-justify-between tw-h-16">
                        <div class="tw-flex">
                            <!-- Logo -->
                            <div class="tw-shrink-0 tw-flex tw-items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="tw-block tw-h-9 tw-w-auto tw-fill-current tw-text-gray-800"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="tw-hidden tw-space-x-8 sm:tw--my-px sm:tw-ms-10 sm:tw-flex">
                                <NavLink :href="route('feed.show')" :active="route().current('feed.show')">
                                    Feed
                                </NavLink>
                            </div>
                        </div>

                        <div class="tw-hidden sm:tw-flex sm:tw-items-center sm:tw-ms-6">
                            <!-- Settings Dropdown -->
                            <div class="tw-ms-3 tw-relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="tw-inline-flex tw-rounded-md">
                                            <button
                                                type="button"
                                                class="tw-inline-flex tw-items-center tw-px-3 tw-py-2 tw-border tw-border-transparent tw-text-sm tw-leading-4 tw-font-medium tw-rounded-md tw-text-gray-500 tw-bg-white tw-hover:tw-text-gray-700 tw-focus:tw-outline-none tw-transition tw-ease-in-out tw-duration-150"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="tw-ms-2 tw--me-0.5 tw-h-4 tw-w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')"> Profile {{ route('profile.edit') }}</DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="tw--me-2 tw-flex tw-items-center sm:tw-hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="tw-inline-flex tw-items-center tw-justify-center tw-p-2 tw-rounded-md tw-text-gray-400 tw-hover:tw-text-gray-500 tw-hover:tw-bg-gray-100 tw-focus:tw-outline-none tw-focus:tw-bg-gray-100 tw-focus:tw-text-gray-500 tw-transition tw-duration-150 tw-ease-in-out"
                           >
                                <svg class="tw-h-6 tw-w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            'tw-hidden': showingNavigationDropdown,
                                            'tw-inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            'tw-hidden': !showingNavigationDropdown,
                                            'tw-inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ 'tw-block': showingNavigationDropdown, 'tw-hidden': !showingNavigationDropdown }"
                    class="sm:tw-hidden"
                >
                    <div class="tw-pt-2 tw-pb-3 tw-space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="tw-pt-4 tw-pb-1 tw-border-t tw-border-gray-200">
                        <div class="tw-px-4">
                            <div class="tw-font-medium tw-text-base tw-text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="tw-font-medium tw-text-sm tw-text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="tw-mt-3 tw-space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="tw-bg-white shadow" v-if="$slots.header">
                <div class="tw-max-w-7xl tw-mx-auto tw-py-6 tw-px-4 sm:tw-px-6 lg:tw-px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
            <!-- <Feed>

            </Feed> -->
        </div>
    </div>
</template>
