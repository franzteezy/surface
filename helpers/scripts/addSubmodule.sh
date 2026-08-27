read -r -p "Please provice the github SSH clone link: " github
read -r -p "What module package do you want to place it in? (e.g. core): " modulePackage
read -r -p "What is the name of this module? (e.g. authorize): " name
read -r -p "Do you want to add module \"${name}\" in \"${modulePackage}\" from \"${github}\"? [y/N]: " allOk


if [[ "$allOk" =~ ^([yY][eE][sS]|[yY])$ ]]
then

    cd ..
    cd ..
    git submodule add ${github} services/${modulePackage}/${name}
    echo "All done!"

else 

    echo "You cancelled the process!"

fi