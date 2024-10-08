<script setup>
import {router, usePage} from '@inertiajs/vue3'
import {computed, ref} from 'vue'

import {
    Dialog,
    DialogPanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
import {
    Bars3Icon,
    Cog6ToothIcon,
    HomeIcon,
    XMarkIcon,
    DocumentIcon,
    ArrowLeftIcon,
} from '@heroicons/vue/24/outline'
import {ChevronDownIcon} from '@heroicons/vue/20/solid'

const page = usePage()
const user = computed(() => page.props.auth.user)

const navigation = [
    {name: 'Dashboard', href: '/home', icon: HomeIcon, current: page.url.startsWith('/home')},
    {name: 'Records', href: '/records', icon: DocumentIcon, current: page.url.startsWith('/records')},
]

const userNavigation = [
    {name: 'Your profile', href: '#'},
    {name: 'Sign out', href: '#'},
]

const sidebarOpen = ref(false)

function logout() {
    router.post('/logout');
}
</script>

<template>
    <div>
        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog class="relative z-50 lg:hidden" @close="sidebarOpen = false">
                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300"
                                 enter-from="opacity-0" enter-to="opacity-100"
                                 leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
                                 leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-900/80"/>
                </TransitionChild>

                <div class="fixed inset-0 flex">
                    <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                                     enter-from="-translate-x-full" enter-to="translate-x-0"
                                     leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
                                     leave-to="-translate-x-full">
                        <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
                            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
                                             enter-to="opacity-100" leave="ease-in-out duration-300"
                                             leave-from="opacity-100" leave-to="opacity-0">
                                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                                    <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                                        <span class="sr-only">Close sidebar</span>
                                        <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true"/>
                                    </button>
                                </div>
                            </TransitionChild>

                            <div
                                class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 pb-4 ring-1 ring-white/10">
                                <div class="flex h-16 shrink-0 items-center">
                                    <img class="h-8 w-auto"
                                         src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
                                         alt="Your Company"/>
                                </div>
                                <nav class="flex flex-1 flex-col">
                                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                        <slot name="side-nav" />

                                        <li>
                                            <ul role="list" class="-mx-2 space-y-1">
                                                <li v-for="item in navigation" :key="item.name">
                                                    <a :href="item.href"
                                                       :class="[item.current ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white', 'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6']">
                                                        <component :is="item.icon" class="h-6 w-6 shrink-0"
                                                                   aria-hidden="true"/>
                                                        {{ item.name }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="mt-auto">
                                            <ul role="list" class="-mx-2 space-y-1">
                                                <li>
                                                    <a href="#"
                                                       class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-400 hover:bg-gray-800 hover:text-white">
                                                        <Cog6ToothIcon class="h-6 w-6 shrink-0" aria-hidden="true"/>
                                                        Settings
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="/logout" @click.prevent="logout"
                                                       class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-400 hover:bg-gray-800 hover:text-white">
                                                        <ArrowLeftIcon class="h-6 w-6 shrink-0" aria-hidden="true"/>
                                                        Logout
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 pb-4">
                <div class="flex h-16 shrink-0 items-center">
                    <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
                         alt="Your Company"/>
                </div>

                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                <li v-for="item in navigation" :key="item.name">
                                    <a :href="item.href"
                                       :class="[item.current ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white', 'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6']">
                                        <component :is="item.icon" class="h-6 w-6 shrink-0" aria-hidden="true"/>
                                        {{ item.name }}
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="mt-auto">
                            <a href="#"
                               class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-400 hover:bg-gray-800 hover:text-white">
                                <Cog6ToothIcon class="h-6 w-6 shrink-0" aria-hidden="true"/>
                                Settings
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="lg:pl-72">
            <div
                class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="sidebarOpen = true">
                    <span class="sr-only">Open sidebar</span>
                    <Bars3Icon class="h-6 w-6" aria-hidden="true"/>
                </button>

                <div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true"/>

                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                    <div class="relative flex flex-1">
                        <slot name="nav-bar" />
                    </div>
                    <div class="flex items-center gap-x-4 lg:gap-x-6">
                        <Menu as="div" class="relative">
                            <MenuButton class="-m-1.5 flex items-center p-1.5">
                                <span class="sr-only">Open user menu</span>
                                <span class="hidden lg:flex lg:items-center">
                                    <span class="ml-4 text-sm font-semibold leading-6 text-gray-900" aria-hidden="true">
                                        {{ user.name }}
                                    </span>
                                    <ChevronDownIcon class="ml-2 h-5 w-5 text-gray-400" aria-hidden="true"/>
                                </span>
                            </MenuButton>
                            <transition enter-active-class="transition ease-out duration-100"
                                        enter-from-class="transform opacity-0 scale-95"
                                        enter-to-class="transform opacity-100 scale-100"
                                        leave-active-class="transition ease-in duration-75"
                                        leave-from-class="transform opacity-100 scale-100"
                                        leave-to-class="transform opacity-0 scale-95">
                                <MenuItems
                                    class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
                                    <MenuItem v-slot="{ active }">
                                        <a href="/logout" @click.prevent="logout"
                                           :class="active ? 'bg-gray-50' : ''"
                                           class="block px-3 py-1 text-sm leading-6 text-gray-900">
                                            Log out
                                        </a>
                                    </MenuItem>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>
            </div>

            <main class="py-5">
                <div class="px-4 sm:px-6 lg:px-8">
                    <slot name="default" />
                </div>
            </main>
        </div>
    </div>
</template>
