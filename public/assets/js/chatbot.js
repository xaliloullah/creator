// _________                        __              /\
// \_   ___ \_______   ____ _____ _/  |_  __________)/ ______
// /    \  \/\_  __ \_/ __ \\__  \\   __\/  _ \_  __ \/  ___/
// \     \____|  | \/\  ___/ / __ \|  | (  <_> )  | \/\___ \
//  \______  /|__|    \___  >____  /__|  \____/|__|  /____  >
//         \/             \/     \/                       \/

/* ---------------------------------------------------------
Nom du fichier : chatbot.js
Auteur : creator's friend studio
Date de création : 22/09/2023
Description : Chatbot personnaliser
Copyright (c) 2023 Creator's Friend Studio
Tous droits réservés.
--------------------------------------------------------- */
$(document).ready(function () {
    var Dialogue = false;
    // Variables pour stocker l'utilisateur
    const User = {
        nom: "",
        age: 0,
    };
    // Variables pour stocker chatbot
    const Chatbot = {
        nom: "Creators",
    };
    // const message = "Je suis disponible à partir de 14h30";
    // const heureregex = /\d{1,2}h\d{1,2}/;
    // const heureTrouvee = message.match(heureregex);

    // if (heureTrouvee !== null) {
    //   const heure = heureTrouvee[0];
    //   "L'utilisateur a saisi l'heure suivante :", heure
    // } else {
    //     "Aucune heure n'a été trouvée dans le message de l'utilisateur."
    // }

    // fonction pour prendre le nom de l'utilisateur
    setTimeout(() => {
        const bienvenue =
            BIENVENUE[Math.floor(Math.random() * BIENVENUE.length)];
        answer = bienvenue;
        addMessage(answer, "chatbot");
    }, timeanswer);
    let timeout;

    function areYouHere() {
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            addMessage("Vous êtes là ?", "chatbot");
        }, 50000);
    }
    // Fonction pour ajouter un message à la fenêtre de chat
    function addMessage(msg, sender) {
        var delay = 20; // Délai en millisecondes entre chaque caractère
        var i = 0;
        var messageBox = $('<div class="' + sender + '"></div>');
        $("#messages").append(messageBox);
        var intervalId = setInterval(function () {
            if (i < msg.length) {
                messageBox.append(msg.charAt(i));
                i++;
            } else {
                clearInterval(intervalId);
            }
        }, delay);
    }

    function getAnswer(question) {
        // Utilisation de Compromise pour analyser la question
        // var doc = nlp(question);
        var reponse = [];
        // Définir les mots-clés et les expressions régulières pour les chercher
        const motscles = {
            salutations: {
                bonjour: /bonjour|bjr/,
                bonsoir: /bonsoir|bsr/,
                salut: /salut|\bslt\b|coucou|\bcc\b|\bhey\b|hello/,
            },
            pronons: {
                je: /je|moi|me|nous|ma|mon|m'/,
                tu: /tu|toi|te|vous|ta|ton|t'/,
            },

            sujets: {
                contacts: /contact|adresse|joindre|telephone/,
                soldes: /solde|solde\s?du\s?compte|montant/,
                depots: /depot|deposer/,
                retraits: /retrait|retirer/,
                transactions:
                    /transactions|transactions\s?récentes|transfert|transferer|virement/,
                demandes: /demande|pret|emprunt/,
                services: /service|offre|produit/,
                comptes: /compte/,
                aides: /aide|help|assister/,
                question:
                    /\bqui\b|\bquoi\b|\bou\b|quand|pourquoi|comment|combien|lequel|laquelle|lesquels|lesquelles|quel/,
            },
            expressions: {
                oui: /\boui\b|ouais|\bwi\b|compris|ok|d'accord|absolument|tout à fait|exactement|biensur|certainement|bien entendu|evidemment|naturellement|confirme|c'est ça|c'est bien ça|c'est exact|cool|super|genial/,
                non: /\bnon\b|peut[- ]etre|pas|pas du tout|\bnn\b|jamais|rien|aucun|pardon/,
                cava: /\bcava\b|\bcv\b|\bca va|\bbien\b|heureux|content|satisfait/,
                nom: /\bnomme\b|appel|\bnom\b|\bsuis\b|prenomme/,
                merci: /merci|merci beaucoup|c'était utile/,
                aurevoir: /ciao\b|\bbye\b|\bbye[ ]bye\b|au[ ]?revoir|a demain/,
                calcul: /\d+/,
            },
            dates: {
                date: /\bdate[s]?\b/,
                jour: /jour|lundi|mardi|mercredi|jeudi|vendredi|samedi|dimanche/,
                heure: /heure[s,e]?|\d{1,2}h\d{0,2}|\d{1,2}h\d{1,2}/,
            },
        };
        // Parcourir les mots-clés et les chercher dans la question
        // salutations
        if (motscles.salutations.bonjour.test(question)) {
            const bonjour = BONJOUR[Math.floor(Math.random() * BONJOUR.length)];
            reponse.push(bonjour + User.nom);
        } else if (motscles.salutations.bonsoir.test(question)) {
            const bonsoir = BONSOIR[Math.floor(Math.random() * BONSOIR.length)];
            reponse.push(bonsoir + User.nom);
        } else if (motscles.salutations.salut.test(question)) {
            const salut = SALUT[Math.floor(Math.random() * SALUT.length)];
            reponse.push(salut + User.nom);
        }
        // fin salutations
        // Sujets
        if (motscles.sujets.contacts.test(question)) {
            reponse.push(
                "Vous pouvez nous joindre sur ce numero : 77839894, envoyer nous un mail sur thecreatorsfriend@gmail.com. Nous sommes disponibles du lundi au vendredi, de 8h00 à 18h00. Certains canaux d'assistance, tels que le service en ligne, peuvent être disponibles 24h/24 et 7j/7."
            );
        } else if (motscles.sujets.soldes.test(question)) {
            reponse.push(
                "Pour vérifier votre solde, vous pouvez vous connecter à votre compte en ligne ou utiliser notre application mobile."
            );
        } else if (motscles.sujets.transactions.test(question)) {
            reponse.push(
                "Pour effectuer un virement bancaire, connectez-vous à votre compte en ligne, sélectionnez le compte source et de destination, entrez le montant, vérifiez les informations du bénéficiaire, puis validez la transaction."
            );
        } else if (motscles.sujets.demandes.test(question)) {
            reponse.push(
                "Si tu souhaites demander un crédit, nous te recommandons de remplir notre formulaire en ligne sur notre site web."
            );
        } else if (motscles.sujets.services.test(question)) {
            reponse.push(
                "Nous proposons une gamme complète de services bancaires, y compris l'ouverture de comptes, les prêts, les cartes de crédit, les services de paiement, les placements, etc"
            );
        } else if (motscles.sujets.comptes.test(question)) {
            reponse.push(
                "Vous pouvez ouvrir un compte en remplissant notre formulaire en ligne sur notre site web ou en vous rendant dans l'une de nos agences. Vous devrez fournir des documents d'identification tels que votre carte d'identité, un justificatif de domicile, etc."
            );
        } else if (motscles.sujets.aides.test(question)) {
            reponse.push(
                "Vous pouvez obtenir de l'aide en nous contactant par téléphone, en envoyant un courrier électronique à notre équipe d'assistance ou en vous rendant dans l'une de nos agences."
            );
        } else if (motscles.sujets.depots.test(question)) {
            reponse.push(
                "Pour effectuer un dépôt sur votre compte, rendez-vous à votre agence bancaire ou utilisez un guichet automatique (DAB) pour déposer l'argent en espèces ou utilisez une fonctionnalité de dépôt mobile dans votre application bancaire pour effectuer un dépôt électronique."
            );
        } else if (motscles.sujets.retraits.test(question)) {
            reponse.push(
                "Pour effectuer un retrait d'argent, vous pouvez vous rendre à un distributeur automatique de billets (DAB) et retirer des espèces en utilisant votre carte bancaire et votre code confidentiel, ou vous rendre à un guichet de votre agence bancaire et effectuer un retrait en personne en présentant une pièce d'identité valide."
            );
        } else if (motscles.sujets.question.test(question)) {
            if (
                motscles.expressions.nom.test(question) ||
                motscles.pronons.tu.test(question)
            ) {
                const presentation =
                    PRESENTATION[
                        Math.floor(Math.random() * PRESENTATION.length)
                    ];
                reponse.push(presentation + User.nom);
            }
        }
        // fin Sujets

        // Expressions
        if (motscles.expressions.oui.test(question)) {
            const oui = OUI[Math.floor(Math.random() * OUI.length)];
            reponse.push(oui);
        } else if (motscles.expressions.non.test(question)) {
            const non = NON[Math.floor(Math.random() * NON.length)];
            reponse.push(non);
        } else if (motscles.expressions.merci.test(question)) {
            const merci = MERCI[Math.floor(Math.random() * MERCI.length)];
            reponse.push(merci);
        } else if (motscles.expressions.aurevoir.test(question)) {
            const aurevoir =
                AUREVOIR[Math.floor(Math.random() * AUREVOIR.length)];
            reponse.push(aurevoir);
        }
        // fin Expressions

        // Vérifier si des réponses ont été trouvées
        if (reponse.length > 0) {
            // Retourner toutes les réponses
            return reponse.join(" ");
        } else {
            const Erreur = ERREUR[Math.floor(Math.random() * ERREUR.length)];
            // Si aucune réponse n'a été trouvée, retourner un message d'erreur
            return Erreur;
        }
    }
    var timeanswer = Math.floor(Math.random() * 1000) + 1000;
    // Répondre à la question lorsque l'utilisateur appuie sur la touche Entrée
    $("#input-chatbot").keypress(function (event) {
        if (event.keyCode == 13) {
            areYouHere();
            var question = $("#input-chatbot")
                .val()
                .toLowerCase()
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "");
            if (question) {
                addMessage(question, "user-chat");
                var answer = getAnswer(question);
                setTimeout(() => {
                    addMessage(answer, "chatbot");
                }, timeanswer);
                $("#input-chatbot").val("");
            }
        }
    });
    // Répondre à la question lorsque l'utilisateur clique sur le bouton "Envoyer"
    $("#send").click(function () {
        areYouHere();
        var question = $("#input-chatbot")
            .val()
            .toLowerCase()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "");
        if (question) {
            addMessage(question, "user-chat");
            var answer = getAnswer(question);
            setTimeout(() => {
                addMessage(answer, "chatbot");
            }, timeanswer);
            $("#input-chatbot").val("");
        }
    });
    // Création des tableau des réponses
    const BIENVENUE = [
        "Mes salutation! comment puis-je t'aider aujourd'hui ?",
        "Bonjour! Je suis votre assistant personel, comment puis-je vous aider aujourd'hui?",
        "Bonjour et bienvenue! Je suis là pour vous fournir un service client exceptionnel et répondre à toutes vos questions.",
        "Bonjour! Je suis heureux de vous accueillir. Comment puis-je vous aider aujourd'hui?",
        "Salut! Je suis ravi de vous rencontrer. Comment puis-je vous être utile?",
        "Salut! Je suis là pour vous aider. Comment puis-je vous assister aujourd'hui?",
        "Bienvenue! Comment puis-je vous épauler dans votre démarche aujourd'hui?",
    ];
    const SALUT = [
        " Comment vas-tu aujourd'hui? Je suis là pour vous aider avec ce dont vous avez besoin.",
        " J'espère que vous allez bien. Comment puis-je vous aider aujourd'hui?",
        " Comment ça va? Je suis là pour vous aider avec tout ce dont vous avez besoin.",
        " Comment vas-tu aujourd'hui? Je suis ravi de vous aider avec vos questions.",
        " Comment allez-vous? Je suis là pour rendre votre journée un peu plus facile.",
        " J'espère que vous allez bien. Comment puis-je vous aider à résoudre vos problèmes?",
        " Comment te sens-tu aujourd'hui? Je suis là pour vous assister dans votre tâche.",
    ];
    const BONJOUR = [
        "Bonjour! comment puis-je t'aider aujourd'hui ?",
        "Hey, bonjour comment ça va ?",
        "Bonjour! ",
        "Bonjour à toi ",
        "Bonjour, comment allez-vous ? ",
        "Bonjour, comment ça va ? ",
        "Bonjour! Comment vas-tu ? ",
    ];
    const BONSOIR = [
        "Mes salutation! comment puis-je t'aider se soir ?",
        "Hey, bonsoir comment ça va ?",
        "Bonsoir ! Comment s'est passée votre journée ?",
        "Bonsoir à toi ",
        "Bonsoir comment allez-vous ? ",
        "Bonsoir ! J'espère que vous passez une bonne soirée.",
    ];
    const OUI = [
        "Super, ",
        "Génial, ",
        "D'accord, ",
        "Parfait, ",
        "Ok, ",
        "Parfait, ",
        "Très bien, ",
    ];
    const NON = [
        "D'accord, ",
        "Je comprends",
        "Pas de soucis, ",
        "Pas de problème, ",
        "Je respecte votre décision, ",
        "Compris,  ",
    ];
    const DISCUSSION = [
        "Super, je suis ravi(e) de discuter avec toi !",
        "Génial, que veux-tu parler ?",
        "D'accord, parlons de quoi exactement ?",
        "Parfait, quel est ton sujet préféré ?",
        "Ok, de quoi as-tu envie de discuter maintenant ?",
        "Parfait, raconte-moi ce qui s'est passé aujourd'hui",
        "Très bien, que recherches-tu dans cette discussion ?",
    ];
    const MERCI = [
        "Le plaisir est pour moi",
        "Je suis heureux/se d'avoir pu vous être utile.",
        "Pas de problème.",
        "Je vous en prie.",
        "C'est toujours un plaisir.",
        "Je suis ravi que vous soyez satisfait.",
        "je suis à votre disposition.",
        "Merci à vous.",
        "Tout est pour le mieux quand je peux aider.",
        "Je suis ravi.",
        "Toujours à votre service.",
    ];
    const CAVA = [
        "Tout va bien, merci. Et toi ?",
        "Ça va super, merci. Et toi ?",
        "Tout baigne, merci. Et toi ?",
        "Je me porte bien, merci. Et toi ?",
        "Très bien, merci. Et toi ?",
        "Je vais très bien, merci. Et toi ?",
        "Je suis en forme, merci. Et toi ?",
        "Je suis de bonne humeur, merci. Et toi ?",
        "Je me sens bien, merci. Et toi ?",
    ];
    const AUREVOIR = [
        "Passez une excellente journée !",
        "Au revoir ! N'hésitez pas à revenir si vous avez d'autres questions ou besoin d'aide.",
        "Merci d'avoir discuté avec moi ! Je suis toujours là si vous avez besoin de moi. À bientôt et prenez soin de vous !",
        "C'était un plaisir de discuter avec vous ! Si vous avez d'autres préoccupations.",
        "je serai ravi de vous aider. Bonne journée et à la prochaine !",
    ];
    const HEUREUX = [
        "Super, content de l'entendre! Comment puis-je vous être utile?",
        "Très bien, je suis heureux que vous alliez bien. Comment puis-je vous assister aujourd'hui?",
        "Ravie de l'apprendre! comment puis-je vous aider à maintenir cet état d'esprit positif?",
        "Parfait, je suis content que vous vous portiez bien. Comment puis-je vous être utile?",
        "Excellente nouvelle! Comment puis-je vous aider à améliorer votre journée?",
        "C'est génial, comment puis-je vous aider à maintenir cette bonne humeur?",
        "Je suis heureux de savoir que tout va bien. Comment puis-je vous aider?",
        "Super, comment puis-je vous aider à maintenir cette bonne humeur?",
        "Très bien, je suis ravi que tout aille bien pour vous. Que puis-je faire pour vous ?",
    ];
    const TRISTE = [
        "Je suis désolé d'entendre ça.",
        "Je suis là pour vous aider si vous en avez besoin.",
        "Je suis là pour vous soutenir.",
        "Je suis désolé que vous ne vous sentiez pas bien.",
        "N'hésitez pas à me dire comment je peux vous aider à vous sentir mieux.",
        "C'est difficile de se sentir mal, mais je suis là pour vous aider.",
        "Je suis désolé d'apprendre que vous ne vous sentez pas bien.",
        "J'aimerais vous aider à vous sentir mieux.",
        "Je suis là pour vous soutenir.",
        "Je suis là pour écouter et vous aider de la manière que je peux.",
    ];
    const PRESENTATION = [
        "Je suis  " +
            Chatbot.nom +
            " Je suis un assistant virtuel conçu pour vous aider dans vos tâches quotidiennes.",
        "Appelez moi " +
            Chatbot.nom +
            " . Mon rôle est de vous aider à résoudre vos problèmes et à répondre à vos questions.",
        "Je réponds au nom de " +
            Chatbot.nom +
            " . Je suis là pour vous aider à accomplir vos tâches plus rapidement et plus efficacement.",
        "Vous pouvez m'appeler " +
            Chatbot.nom +
            ". Je suis conçu pour simplifier votre vie quotidienne en vous assistant dans toutes vos tâches.",
        "Mon nom est " +
            Chatbot.nom +
            ". Je suis un assistant personnel et je suis là pour vous aider dans tout ce dont vous avez besoin.",
        "Je suis connu sous le nom de " +
            Chatbot.nom +
            ". Je suis conçu pour rendre votre expérience utilisateur plus agréable et plus productive.",
        "On m'appelle " +
            Chatbot.nom +
            ". Je suis là pour vous aider avec tout ce dont vous avez besoin et pour rendre votre vie plus simple.",
    ];
    const TOIOUMOI = [
        "Pouvez-vous préciser si vous parlez de vous ou de moi ?.",
        "Voulez-vous que je parle de moi ou de vous ?",
        "Pouvez-vous me dire si vous voulez en savoir plus sur vous-même ou sur moi ?",
        "Souhaitez-vous parler de votre vie personnelle ?",
        "Vous parler de vous ?",
    ];
    const ERREUR = [
        "désolé, je n'ai pas compris.",
        "Je ne suis pas sûr de bien comprendre.",
        "je ne suis pas sûr de saisir",
        "Je m'excuse, je n'ai pas saisi ce que vous voulez dire.",
        "Je suis désolé, je n'ai pas compris.",
        "Pardon, je ne suis pas sûr de comprendre.",
        "Pouvez-vous me donner plus d'informations sur ce que vous voulez dire ?",
    ];
    const BLAGUE = [
        "Bien sûr, voici une blague courte :Pourquoi les électriciens ne courent-ils jamais dans les escaliers ? Parce qu'ils ont peur de faire des courts-circuits !",
        "Pourquoi les plongeurs plongent-ils toujours en arrière et jamais en avant ? Parce que sinon ils tombent dans le bateau !",
        "Qu'est-ce qu'un chat dit quand il est surpris ?\n \n \n 'Mi-aou !'.",
        "Pourquoi les plongeurs plongent-ils toujours en arrière et jamais en avant ? Parce que sinon ils tombent dans le bateau !",
    ];
    const REVERCE = [
        " moi aussi.",
        " de même.",
        " de même pour moi.",
        " moi de même.",
        " pareillement.",
        " idem.",
    ];
    const INCONNUE = [
        "Je n'ai pas été formé pour savoir",
        "Je ne suis pas compétent en ce qui concerne",
        "Je n'ai pas les compétences requises pour savoir",
        "Je ne suis pas habilité à savoir",
        "Je n'ai pas les connaissances nécessaires pour savoir",
        "Je ne suis pas qualifié pour connaître",
        "Je ne suis pas en mesure de répondre à ",
    ];
});
