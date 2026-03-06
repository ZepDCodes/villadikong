/**
 * CONFIGURATION: Edit this section to build your virtual tour.
 * You can now use 'actions' instead of 'hotspots' for button-based navigation.
 */
const tourData = [
    {
        id: 'outside',
        title: 'Outside Entrance',
        description: 'Here you can see the outside of the rooms, and this is also the entrance, and if you go further you reach the pool side area.',
        imageUrl: 'room_images/outside.jpg',
        hotspots: [
            { targetId: 'room', top: '38%', left: '42%', tooltip: 'Go to room 1' },
            { targetId: 'outside_room2', top: '39%', left: '60%', tooltip: 'Go to room 2' },
            { targetId: 'pool_bar', top: '39%', left: '73%', tooltip: 'go to poolside area' },
            { targetId: 'pool_bathroom', top: '42%', left: '66%', tooltip: 'go to pool bathroom' },
        ]
    },
    {
        id: 'room',
        title: 'living area',
        description: 'this living area is all in one style, where kitchen and balcony area is combined',
        imageUrl: 'room_images/room1.jpg',
        hotspots: [
            { targetId: 'kitchen area', top: '46%', left: '61%', tooltip: 'see kitchen' },
            { targetId: 'bed_room1', top: '50%', left: '8%', tooltip: 'see bedroom area' },
            
        ],
         actions: [
            { label: '➥ Go back to Outside', targetId: 'outside' }
        ]
    },
    {
        id: 'balcony',
        title: 'Balcony area',
        description: 'You can relaxe in humble balcony area.',
        imageUrl: 'room_images/balcon_room1.jpg',
        hotspots: [
            { targetId: 'kitchen area', top: '48%', left: '8%', tooltip: 'Go back inside' }
        ],
        actions: [
            { label: '➥ Back', targetId: 'room' }
        ]
    },
    {
        id: 'kitchen area',
        title: 'Kitchen area',
        description: 'Perfect for dinner or enjoying family meals.',
        imageUrl: 'room_images/kitchen_room1.jpg',
        hotspots: [
            { targetId: 'bathroom1', top: '30%', left: '43%', tooltip: 'bathroom'}
        ]
    },
    {
        id: 'bed_room1',
        title: 'Bedroom',
        description: 'A tranquil retreat with a large bed, and with large tv and an soothing airconditioning.',
        imageUrl: 'room_images/bedroom_room1.jpg',  

        actions:[
            { label: '➥ Return to living area', targetId: 'room' }
        ]
    },
    {
        id: 'bathroom1',
        title: 'Bathroom',
        description: 'simple, cozy and clean.',
        imageUrl: 'room_images/bathroom_room1.jpg',
        actions: [
            { label: '➥ Return to living area', targetId: 'room' }
        ]
    },
    {
        id: 'bed',
        title: 'cozy bed',
        description: 'Perfect for family and couples.',
        imageUrl: 'room_images/bed_room1.jpg',
        actions: [
            { label: '➥ Back', targetId: 'bed_room1' },
        ]
    },
    {
        id: 'pool_bar',
        title: 'pool bar',
        description: '',
        imageUrl: 'poolside/pool_bar.jpg',
         hotspots: [
            { targetId: 'pool', top: '53%', left: '48%', tooltip: 'go pool' },
            { targetId: 'karaoke_machine', top: '51%', left: '12%', tooltip: 'see karaoke' },
            { targetId: 'pool_dining_area', top: '45%', left: '68%', tooltip: 'go to dining area' },
        ],
         actions: [
            { label: '➥ Back', targetId: 'outside' },
        ]
    },
     {
        id: 'karaoke_machine',
        title: 'Karaoke machine',
        description: '',
        imageUrl: 'poolside/karaoke.jpg',
         actions: [
            { label: '➥ Back', targetId: 'pool_bar' },
        ]
       
    },
    {
        id: 'pool',
        title: 'Pool',
        description: 'here you can enjoy and relax at the pool area with kiddie pool for your kids.',
        imageUrl: 'poolside/pool.jpg',
         actions: [
            { label: '➥ Back', targetId: 'pool_bar' },
        ]
       
    },
    {
        id: 'pool_dining_area',
        title: 'Pool dining area',
        description: 'here are tables you can sit and eat you food with your family.',
        imageUrl: 'poolside/pool_dining_area.jpg',
         actions: [
            { label: '➥ Back', targetId: 'pool_bar'},
        ]

    },
    {
        id: 'pool_bathroom',
        title: 'Poolside bathrooms',
        description: 'this is the poolside bathroom, that you can rinse or shower.',
        imageUrl: 'poolside/poolside_bathroom.jpg',
         hotspots: [
            { targetId: 'poolside_CR1', top: '51%', left: '15%', tooltip: 'go t0 CR1' },
            { targetId: 'poolside_CR2', top: '51%', left: '30%', tooltip: 'go t0 CR2' },
            { targetId: 'pool_bar', top: '45%', left: '88%', tooltip: 'go to poolside area' },
        ]
    },
    {
        id: 'poolside_CR1',
        title: 'CR1',
        description: 'bathrooms near poolside area.',
        imageUrl: 'poolside/cr1.jpg',
         actions: [
            { label: '➥ Back', targetId: 'pool_bathroom'},
        ]

    },
        {
        id: 'poolside_CR2',
        title: 'CR2',
        description: 'bathrooms near poolside area.',
        imageUrl: 'poolside/cr2.jpg',
         actions: [
            { label: '➥ Back', targetId: 'pool_bathroom'},
        ]

    },
//-- Room 2 dito sa baba ---
    {
        id: 'outside_room2',
        title: 'Outside of room 2',
        description: '',
        imageUrl: 'room2_images/outside_room2.jpg',
        hotspots: [
            { targetId: 'living_area_room2', top: '48%', left: '46%', tooltip: 'Enter room 2' },
            { targetId: 'pool_bar', top: '44%', left: '82%', tooltip: 'poolside' }
        ]
       
    },
    {
        id: 'living_area_room2',
        title: 'Living area in Room 2',
        description: 'Same layout in the room 2, cozy and simple.',
        imageUrl: 'room2_images/living_area_room2.jpg',
        hotspots: [
            { targetId: 'bedroom2', top: '48%', left: '82%', tooltip: 'Enter room 2 area' },
        ],
        actions:[
            { label: '➥ Back outside', targetId: 'outside' }
        ]
       
    },
    {
        id: 'bedroom2',
        title: 'bedroom layout of Room 2',
        description: '',
        imageUrl: 'room2_images/bedroom_room2.jpg',
        hotspots: [
           
        ],
        actions:[
            { label: '➥ Back', targetId: 'living_area_room2' }
        ]
       
    },
    {
        id: 'bedofroom2',
        title: 'Bed of Room 2',
        description: '',
        imageUrl: 'room2_images/bed_room2.jpg',
        actions:[
            { label: '➥ Back', targetId: 'bedroom2' }
        ]
       
    },
    
];

// --- SCRIPT LOGIC below ---

document.addEventListener('DOMContentLoaded', () => {
    const mainImageElement = document.getElementById('main-tour-image');
    const titleElement = document.getElementById('tour-title');
    const descriptionElement = document.getElementById('tour-description');
    const hotspotsContainer = document.getElementById('hotspots-container');
    const actionsContainer = document.getElementById('tour-actions-container');
    
    // The 'navigationContainer' variable has been removed.
    
    let currentSceneId = tourData[0].id;

    function updateTourView(sceneId) {
        const sceneData = tourData.find(stop => stop.id === sceneId);
        if (!sceneData) return;
        
        currentSceneId = sceneId;
        mainImageElement.classList.add('fading-out');
        
        setTimeout(() => {
            mainImageElement.src = sceneData.imageUrl;
            titleElement.textContent = sceneData.title;
            descriptionElement.textContent = sceneData.description;

            hotspotsContainer.innerHTML = '';
            actionsContainer.innerHTML = '';
            
            if (sceneData.hotspots) {
                sceneData.hotspots.forEach(hotspot => {
                    const hotspotElem = document.createElement('div');
                    hotspotElem.classList.add('hotspot');
                    hotspotElem.style.top = hotspot.top;
                    hotspotElem.style.left = hotspot.left;
                    hotspotElem.title = hotspot.tooltip;
                    hotspotElem.addEventListener('click', () => updateTourView(hotspot.targetId));
                    hotspotsContainer.appendChild(hotspotElem);
                });
            }

            if (sceneData.actions) {
                sceneData.actions.forEach(action => {
                    const actionButton = document.createElement('button');
                    actionButton.classList.add('tour-action-button');
                    actionButton.textContent = action.label;
                    actionButton.addEventListener('click', () => updateTourView(action.targetId));
                    actionsContainer.appendChild(actionButton);
                });
            }

            mainImageElement.classList.remove('fading-out');
            // The call to 'updateNavigationActiveState()' has been removed.
        }, 300);
    }

    function initializeTour() {
        // The loop that created the navigation buttons has been removed.
        updateTourView(tourData[0].id);
    }

    initializeTour();
});